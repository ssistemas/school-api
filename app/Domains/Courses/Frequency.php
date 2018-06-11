<?php

namespace Emtudo\Domains\Courses;

use Emtudo\Domains\Calendars\SchoolDay;
use Emtudo\Domains\Courses\Resources\Rules\FrequencyRules;
use Emtudo\Domains\Courses\Transformers\FrequencyTransformer;
use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Shield\HasRules;

/**
 * Class Frequency.
 */
class Frequency extends TenantModel
{
    use HasRules;

    /**
     * @var string
     */
    protected static $rulesFrom = FrequencyRules::class;

    /**
     * @var string
     */
    protected $transformerClass = FrequencyTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id',
        'school_day_id',
        'student_id',
        'present',
        'justified_absence',
    ];

    public function tenant()
    {
        return $this->hasOneThroughSeveral([
            Tenant::class,
            Course::class,
            Group::class,
            Schedule::class,
        ]);
    }

    public function course()
    {
        return $this->hasOneThroughSeveral([
            Course::class,
            Group::class,
            Schedule::class,
        ]);
    }

    public function group()
    {
        return $this->hasOneThroughSeveral([
            Group::class,
            Schedule::class,
        ]);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function subject()
    {
        return $this->hasOneThroughSeveral([
            Subject::class,
            Skill::class,
            Schedule::class,
        ]);

        return $this->hasOneThroughSeveral([
            Subject::class => [
                'subjects.id' => 'skills.subject_id',
            ],
            Skill::class => [
                'skills.id' => 'schedules.skill_id',
            ],
            Schedule::class => [
                'schedules.id' => 'frequencies.schedule_id',
            ],
        ]);
    }

    public function schoolDay()
    {
        return $this->belongsTo(SchoolDay::class);
    }
}
