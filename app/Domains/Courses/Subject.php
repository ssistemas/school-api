<?php

namespace Emtudo\Domains\Courses;

use Emtudo\Domains\Courses\Resources\Rules\SubjectRules;
use Emtudo\Domains\Courses\Transformers\SubjectTransformer;
use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Teacher;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends TenantModel
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = SubjectRules::class;

    /**
     * @var string
     */
    protected $transformerClass = SubjectTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_subject')
            ->using(GroupSubjectPivot::class);
    }

    public function getStudents()
    {
        return $this->enrollments()
            ->with('student')
            ->get()
            ->map(function ($enrollment) {
                return $enrollment->student;
            });
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'skills');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
}
