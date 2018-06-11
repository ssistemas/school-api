<?php

namespace Emtudo\Domains\Courses;

use Emtudo\Domains\Courses\Resources\Rules\QuizRules;
use Emtudo\Domains\Courses\Transformers\QuizTransformer;
use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Teacher;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Quiz.
 */
class Quiz extends TenantModel
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = QuizRules::class;

    /**
     * @var string
     */
    protected $transformerClass = QuizTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id',
        'kind',
        'label',
        'score',
        'date',
        'proof_of_recovery',
    ];

    protected $dates = [
        'date',
    ];

    public function tenant()
    {
        return $this->hasOneThroughSeveral([
            Tenant::class,
            Course::class,
            Group::class,
        ]);
    }

    public function course()
    {
        return $this->hasOneThroughSeveral([
            Course::class,
            Schedule::class,
            Group::class,
        ]);
    }

    public function group()
    {
        return $this->hasOneThroughSeveral([
            Group::class,
            Schedule::class,
        ]);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function forceGetSchedule()
    {
        return Schedule::find($this->schedule_id);
    }

    public function subject()
    {
        return $this->hasOneThroughSeveral([
            Subject::class,
            Schedule::class,
            Skill::class,
        ]);
    }

    public function teacher()
    {
        return $this->hasOneThroughSeveral([
            Teacher::class,
            Schedule::class,
            Skill::class,
        ]);
    }
}
