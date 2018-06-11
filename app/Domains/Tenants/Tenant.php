<?php

namespace Emtudo\Domains\Tenants;

use Emtudo\Domains\Calendars\Calendar;
use Emtudo\Domains\Calendars\Event;
use Emtudo\Domains\Courses\Course;
use Emtudo\Domains\Courses\Enrollment;
use Emtudo\Domains\Courses\Frequency;
use Emtudo\Domains\Courses\Grade;
use Emtudo\Domains\Courses\Group;
use Emtudo\Domains\Courses\Quiz;
use Emtudo\Domains\Courses\Schedule;
use Emtudo\Domains\Courses\Subject;
use Emtudo\Domains\Model;
use Emtudo\Domains\Tenants\Resources\Rules\TenantRules;
use Emtudo\Domains\Tenants\Transformers\TenantTransformer;
use Emtudo\Domains\Users\User;
use Emtudo\Domains\Users\UserTenantPivot;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Class Tenant.
 *
 * @property string $name
 * @property string $label
 * @property string $country_register
 * @property string $city_register
 * @property string $state_register
 */
class Tenant extends Model
{
    use HasRules, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = TenantRules::class;

    /**
     * @var Tenant
     */
    protected static $currentTenant;

    /**
     * @var string
     */
    protected $transformerClass = TenantTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'label',
        'status',
        'usage_date',
        'country_register',
        'state_register',
        'city_register',
        'email',
        'mei',
        'address',
        'phones',
        'director_id',
    ];

    protected $dates = [
        'usage_date',
    ];

    protected $casts = [
        'address' => 'array',
        'phones' => 'array',
    ];

    /**
     * @param string $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    /**
     * @return null|Tenant
     */
    public static function currentTenant()
    {
        if (empty(self::$currentTenant)) {
            return self::currentTenantByLoggedUser();
        }

        return self::$currentTenant;
    }

    /**
     * @param Tenant $tenant
     */
    public static function setCurrentTenant(self $tenant)
    {
        self::$currentTenant = $tenant;
    }

    /**
     * @return null|Tenant
     */
    public static function currentTenantByLoggedUser()
    {
        if (!app('auth')->check()) {
            return self::$currentTenant;
        }

        /** @var User $user */
        $user = auth()->user();

        if ($user->last_tenant && $user->belongsToTenant($user->last_tenant)) {
            if ($user->master) {
                self::$currentTenant = self::find($user->last_tenant);
            } else {
                self::$currentTenant = $user->tenants()->find($user->last_tenant);
            }
        } else {
            $firstTenant = $user->tenants()->first();
            self::$currentTenant = $firstTenant;
            $user->last_tenant = $firstTenant->id ?? null;
            $user->save();
        }

        return self::$currentTenant;
    }

    /**
     * @return \Closure
     */
    public static function resolveCurrentTenant()
    {
        return function () {
            return Tenant::currentTenant();
        };
    }

    /**
     * Attach an user into this Tenant.
     *
     * @param User   $user
     * @param string $type
     */
    public function attachUser(User $user, $type)
    {
        $this->users()->attach($user->id, [$type => true]);
    }

    public function director()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tenants_users')
            ->withPivot(['student', 'responsible', 'teacher', 'manager'])
            ->withTimestamps()
            ->using(UserTenantPivot::class);
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function frequencies()
    {
        return $this->hasMany(Frequency::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
