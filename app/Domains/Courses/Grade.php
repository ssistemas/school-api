<?php

namespace Emtudo\Domains\Courses;

use Emtudo\Domains\Courses\Resources\Rules\GradeRules;
use Emtudo\Domains\Courses\Transformers\GradeTransformer;
use Emtudo\Domains\Model;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Grade.
 */
class Grade extends Model
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = GradeRules::class;

    /**
     * @var string
     */
    protected $transformerClass = GradeTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'quiz_id',
        'value',
    ];

    public function tenant()
    {
        return $this->hasOneThroughSeveral([
            Tenant::class,
            Course::class,
            Group::class,
            Quiz::class,
        ]);
    }

    public function course()
    {
        return $this->hasOneThroughSeveral([
            Course::class,
            Group::class,
            Quiz::class,
        ]);
    }

    public function group()
    {
        return $this->hasOneThroughSeveral([
            Group::class,
            Quiz::class,
        ]);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
