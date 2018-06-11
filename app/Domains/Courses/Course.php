<?php

namespace Emtudo\Domains\Courses;

use Emtudo\Domains\Courses\Resources\Rules\CourseRules;
use Emtudo\Domains\Courses\Transformers\CourseTransformer;
use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Course.
 */
class Course extends TenantModel
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = CourseRules::class;

    /**
     * @var string
     */
    protected $transformerClass = CourseTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'max_periods',
        'division_period',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
