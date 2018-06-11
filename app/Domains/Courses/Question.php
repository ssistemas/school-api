<?php

namespace Emtudo\Domains\Courses;

use Emtudo\Domains\Courses\Resources\Rules\QuestionRules;
use Emtudo\Domains\Courses\Transformers\QuestionTransformer;
use Emtudo\Domains\Model;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Teacher;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Question.
 */
class Question extends Model
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = QuestionRules::class;

    /**
     * @var string
     */
    protected $transformerClass = QuestionTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',
        'ask',
        'question',
        'answer',
    ];

    public function tenant()
    {
        return $this->hasOneThroughSeveral([
            Tenant::class,
            Course::class,
            Group::class,
            Schedule::class,
            Quiz::class,
        ]);
    }

    public function course()
    {
        return $this->hasOneThroughSeveral([
            Course::class,
            Group::class,
            Schedule::class,
            Quiz::class,
        ]);
    }

    public function group()
    {
        return $this->hasOneThroughSeveral([
            Group::class,
            Schedule::class,
            Quiz::class,
        ]);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function skill()
    {
        return $this->hasOneThroughSeveral([
            Skill::class,
            Group::class,
            Schedule::class,
            Quiz::class,
        ]);
    }

    public function teacher()
    {
        return $this->hasOneThroughSeveral([
            Teacher::class,
            Skill::class,
            Quiz::class,
        ]);
    }

    public function subject()
    {
        return $this->hasOneThroughSeveral([
            Subject::class,
            Skill::class,
            Quiz::class,
        ]);
    }
}
