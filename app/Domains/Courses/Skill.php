<?php

namespace Emtudo\Domains\Courses;

use Emtudo\Domains\Courses\Resources\Rules\SkillRules;
use Emtudo\Domains\Courses\Transformers\SkillTransformer;
use Emtudo\Domains\Model;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Skill.
 */
class Skill extends Model
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = SkillRules::class;

    /**
     * @var string
     */
    protected $transformerClass = SkillTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'subject_id',
    ];

    public function tenant()
    {
        return $this->hasOneThroughSeveral([
            Tenant::class,
            Subject::class,
        ]);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function getShortLabel()
    {
        return $this->subject->label;
    }

    public function getLabel()
    {
        return $this->subject->label.' - '.$this->teacher->name;
    }
}
