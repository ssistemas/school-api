<?php

namespace Emtudo\Domains\Users;

use Emtudo\Domains\Courses\Enrollment;
use Emtudo\Domains\Courses\Frequency;
use Emtudo\Domains\Courses\Grade;
use Emtudo\Domains\Courses\Group;
use Emtudo\Domains\Courses\Quiz;
use Emtudo\Domains\Courses\Schedule;
use Emtudo\Domains\Courses\Skill;
use Emtudo\Domains\Courses\SkillUserPivot;
use Emtudo\Domains\Courses\Subject;
use Emtudo\Domains\Files\FileableTrait;
use Emtudo\Domains\Model;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Resources\Rules\UserRules;
use Emtudo\Domains\Users\Transformers\UserTransformer;
use Emtudo\Support\Notifications\InviteNotification;
use Emtudo\Support\Notifications\ResetPassword as ResetPasswordNotification;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use HasRules;
    use SoftDeletes;
    use Notifiable;
    use Authenticatable;
    use CanResetPassword;
    use Authorizable;
    use FileableTrait;

    public static $inviteRoute;
    public static $resetPasswordRoute;

    /**
     * @var Rules class
     */
    protected static $rulesFrom = UserRules::class;

    /**
     * @var string user transformer class
     */
    protected $transformerClass = UserTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'country_register',
        'birthdate',
        'state_register',
        'state_register_state',
        'state_register_entity',
        'address',
        'phones',
    ];

    protected $casts = [
        'address' => 'array',
        'phones' => 'array',
        'documents' => 'json',
    ];

    protected $dates = [
        'birthdate',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param string $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function belongsToTenant($tenantId)
    {
        if ($this->is_admin) {
            return true;
        }

        return $this->tenants()
            ->select('id')
            ->where('tenants.id', $tenantId)
            ->exists();
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $link = str_replace('{token}', $token, urldecode(self::$resetPasswordRoute));

        $this->notify(new ResetPasswordNotification($link));
    }

    public function customJWTClaims()
    {
        return [
            'mas' => (bool) $this->master,
            'nam' => $this->name,
            'ema' => $this->email,
        ];
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'last_tenant');
    }

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'tenants_users', 'user_id')
            ->withPivot(['student', 'responsible', 'teacher', 'manager'])
            ->withTimestamps()
            ->using(UserTenantPivot::class);
    }

    /**
     * Send the invite to the user.
     *
     * @param Invite $invite
     */
    public function sendInviteNotification($invite)
    {
        $link = str_replace('{token}', $invite->token, self::$inviteRoute);

        $this->notify(new InviteNotification($invite, $link));
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function frequencies()
    {
        return $this->hasMany(Frequency::class, 'student_id');
    }

    public function getFrequencies($group = null, $year = null, $month = null)
    {
        $query = $this->frequencies();
        if ($year || $month) {
            $query->whereHas('schoolDay', function ($query) use ($year, $month) {
                if ($year) {
                    $query->whereYear('date', $year);
                }
                if ($month) {
                    $query->whereMonth('date', $month);
                }
            });
        }
        if ($group) {
            $query->whereHas('schedule', function ($query) use ($group) {
                $query->where('group_id', $group);
            });
        }

        return $query->get();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'teacher_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Subject::class, 'skills', 'teacher_id')
            ->using(SkillUserPivot::class);
    }

    public function isAdmin()
    {
        return (bool) $this->is_admin;
    }

    public function getProfile($profile)
    {
        $tenant = $this->tenants()
            ->with(['users' => function ($query) {
                $query->where('id', $this->id);
            }])
            ->where('id', tenant()->id)
            ->first();
        if (!$tenant) {
            return false;
        }

        return (bool) $tenant->pivot->{$profile} ?? false;
    }

    public function isStudent()
    {
        return $this->enrollments()
            ->select('tenant_id')
            ->where('tenant_id', tenant()->id)
            ->exists();
    }

    public function isManager()
    {
        return $this->tenants()
            ->select('tenant_id')
            ->where('tenant_id', tenant()->id)
            ->where('director_id', $this->id)
            ->exists();
    }

    public function isTeacher()
    {
        return Skill::select('id')
            ->where('teacher_id')
            ->where('tenant_id', tenant()->id)
            ->where('teacher_id', $this->id)
        // ->whereHas('schedules', function ($query) {
        //     return $query->select('id');
        // })
            ->exists();
    }

    public function isResponsible()
    {
        $id = $this->id;

        return self::newQuery()
            ->select('id')
            ->where('parent1_id', $id)
            ->orWhere('parent2_id', $id)
            ->orWhere('responsible1_id', $id)
            ->orWhere('responsible2_id', $id)
            ->exists();
    }

    public function getAvatarUrl()
    {
        $filename = 'users/'.$this->id.'.'.$this->avatar_exten;
        if (storage_file_exists('avatars', $filename)) {
            return storage_file_url('avatars', $filename);
        }

        return storage_file_url('avatars', 'avatar.png');
    }

    public function deleteDocumentByKind($kind)
    {
        $document = $this->documents[$kind] ?? '';
        $filename = "{$this->id}/{$document}";

        if (storage_file_exists('documents', $filename)) {
            return storage_file_delete('documents', $filename);
        }

        return true;
    }

    public function getDocumentFilename($kind)
    {
        $document = $this->documents[$kind] ?? '';

        return "{$this->id}/{$document}";
    }

    public function getDocumentByKind($kind)
    {
        $filename = $this->getDocumentFilename($kind);

        if (storage_file_exists('documents', $filename)) {
            return storage_file_get('documents', $filename);
        }

        return false;
    }

    public function getBase64DocumentByKind($kind)
    {
        $file = $this->getDocumentByKind($kind);
        if ($file) {
            return [
                'filename' => $this->documents[$kind],
                'content' => base64_encode($file),
                'mime' => storage_file_mime('documents', $this->getDocumentFilename($kind)),
            ];
        }

        return false;
    }

    public function subjectsFromGroup(Group $group)
    {
        $group->subjects;
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function getGradesFrom($date = null, $group = null, $subject = null)
    {
        $query = $this->hasManyThroughSeveral([
            Grade::class => [
                'grades.quiz_id' => 'quizzes.id',
            ],
            Quiz::class => [
                'quizzes.schedule_id' => 'schedules.id',
            ],
            Schedule::class => [
                'groups.id' => 'schedules.group_id',
            ],
            Group::class,
            Enrollment::class => [
                'enrollments.student_id' => 'users.id',
            ],
        ]);
        $query->whereColumn('grades.student_id', 'users.id');
        // $query->addSelect('quizzes.id as quiz_id');
        // // $query->addSelect('groups.id as group_id');
        // $query->addSelect('enrollments.id as enrollment_id');
        // $query->addSelect('users.id as student_id');
        if ($date) {
            if (is_array($date) && 2 === count($date)) {
                $query->whereBetween('quizzes.date', $date);
            } else {
                $query->where('quizzes.date', $date);
            }
        }
        if ($group) {
            $query->where('groups.id', $group);
        }
        if ($subject) {
            $query->where('subjects.id', $subject);
        }

        if ($date || $group || $subject) {
            return $query->get();
        }

        return $query;
    }

    public function userIsResponsibleOfStudent($studentId)
    {
        if ($this->isAdmin()) {
            return true;
        }
        if ($studentId === $this->id) {
            return true;
        }

        return self::where('id', $studentId)
            ->where(function ($query) {
                $query->where('parent1_id', $this->id)
                    ->orWhere('parent2_id', $this->id)
                    ->orWhere('responsible1_id', $this->id)
                    ->orWhere('responsible2_id', $this->id);
            })
            ->exists();
    }
}
