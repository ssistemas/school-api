<?php

namespace Emtudo\Domains\Courses;

use DB;
use Emtudo\Domains\Courses\Resources\Rules\GroupRules;
use Emtudo\Domains\Courses\Transformers\GroupTransformer;
use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Student;
use Emtudo\Domains\Users\Teacher;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Group.
 */
class Group extends TenantModel
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = GroupRules::class;

    /**
     * @var string
     */
    protected $transformerClass = GroupTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'label',
        'year',
        'max_students',
        'pass_score',
        'period',
    ];

    public function tenant()
    {
        return $this->hasOneThroughSeveral([
            Course::class,
        ]);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function getQuizzes($userId = null)
    {
        return Quiz::whereHas('schedule', function ($query) use ($userId) {
            $query->when($userId, function ($query) use ($userId) {
                $query->whereHas('skill', function ($query) use ($userId) {
                    $query->where('teacher_id', $userId);
                });
            })
                ->whereHas('group', function ($query) {
                    $query->where('id', $this->id);
                });
        })->get();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function schedulesFromUser($user = null)
    {
        if ($user) {
            $userId = $user;
        }
        if ($user instanceof User) {
            $userId = $user->id;
        }
        if (!$user) {
            $userId = auth()->user()->id;
        }

        return $this->schedules()
            ->whereHas('skill', function ($query) use ($userId) {
                $query->where('teacher_id', $userId);
            })
            ->with(['skill' => function ($query) use ($userId) {
                $query->where('teacher_id', $userId);
            }])
            ->get();
    }

    public function skills($where = [])
    {
        // model = group
        // groups.id = schedules.group_id
        // skills.id = schedules.skill_id
        $query = $this->belongsToMany(
            Skill::class,
            'schedules'
        );

        if (!empty($where)) {
            $query->where($where);
        }

        return $query;
    }

    public function skillsFromUser($user = null)
    {
        if ($user) {
            $userId = $user;
        }
        if ($user instanceof User) {
            $userId = $user->id;
        }
        if (!$user) {
            $userId = auth()->user()->id;
        }

        return $this->skills(['skills.teacher_id' => $userId])->get();
    }

    public function subjects()
    {
        return $this->hasManyThroughSeveral([
            Subject::class,
            Skill::class,
            Schedule::class => [
                'schedules.group_id' => 'groups.id',
            ],
        ]);
    }

    // public function subjects()
    // {
    //     return $this->hasManyThroughSeveral(
    //         Subject::class,
    //         Skill::class,
    //         Schedule::class,
    //         null, // options -> group_id [schedules.group_id] (foreighKey from group)
    //         null, // options ->  group_id [schedules.group_id] (where schedules.group_id = ?)
    //         null, // options -> subject_id [skills.subject_id]
    //         null, // options -> id [groups.id]
    //         true, // options -> distinct subjects [default: true]
    //         []// options -> filters's subjects ['name' => 'Leandro']
    //     );
    // }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withTimestamps();
    }

    public function teachers()
    {
        // model = group
        // groups.id = schedules.group_id
        // skills.id = schedules.skill_id
        // teachers.id = skills.teacher_id

        // $throughSecond = new $throughSecond();
        // $through = new $through();
        //
        //         // $firstKey = $firstKey ?: $this->getForeignKey();
        //
        //         // $secondKey = $secondKey ?: $throughSecond->getForeignKey();
        //
        //         // $thirdKey = $thirdKey ?: ($through->getTable().'.'.$instance->getForeignKey());
        //
        //         // $localKey = $localKey ?: $this->getKeyName();
        //
        //         // $secondLocalKey = $secondLocalKey ?: $throughSecond->getKeyName();
        //
        // $thirdLocalKey = $thirdLocalKey ?: ($instance->getTable().'.'.$instance->getKeyName());

        return $this->hasManyThroughSeveral([
            Teacher::class,
            Skill::class,
            Schedule::class => [
                'schedules.group_id' => 'groups.id',
            ],
        ]);
    }

    public function getAvailabelVacancies()
    {
        return (int) DB::SELECT(
            "
            select sum(available) as available from (
                select (groups.max_students - count(enrollments.group_id)) as available from groups
                    LEFT JOIN enrollments ON enrollments.group_id = groups.id
                    WHERE groups.id = {$this->id}
                    GROUP by groups.id) as groups
            "
        )[0]->available ?? 0;
    }

    // public function teachers()
    // {
    //         // model = group
    //         // groups.id = schedules.group_id
    //         // skills.id = schedules.skill_id
    //         // teachers.id = skills.teacher_id
    //
    //         // $throughSecond = new $throughSecond();
    //         // $through = new $through();
    //         //
    //         //         // $firstKey = $firstKey ?: $this->getForeignKey();
    //         //
    //         //         // $secondKey = $secondKey ?: $throughSecond->getForeignKey();
    //         //
    //         //         // $thirdKey = $thirdKey ?: ($through->getTable().'.'.$instance->getForeignKey());
    //         //
    //         //         // $localKey = $localKey ?: $this->getKeyName();
    //         //
    //         //         // $secondLocalKey = $secondLocalKey ?: $throughSecond->getKeyName();
    //         //
    //         // $thirdLocalKey = $thirdLocalKey ?: ($instance->getTable().'.'.$instance->getKeyName());
    //
    //         return $this->hasManyThroughSeveral(
    //             Teacher::class,
    //             Skill::class,
    //             Schedule::class,
    //             null, // options -> group_id [schedules.group_id] (foreighKey from group)
    //             null, // options ->  group_id [schedules.group_id] (where schedules.group_id = ?)
    //             null, // options -> teacher_id [skills.teacher_id]
    //             null, // options -> id [groups.id]
    //             true, // options -> distinct teachers [default: true]
    //             []// options -> filters's teachers ['name' => 'Leandro']
    //         );
    // }
}
