<?php

namespace Emtudo\Domains\Courses;

use Emtudo\Domains\Courses\Resources\Rules\EnrollmentRules;
use Emtudo\Domains\Courses\Transformers\EnrollmentTransformer;
use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Transports\Route;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Enrollment.
 */
class Enrollment extends TenantModel
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = EnrollmentRules::class;

    /**
     * @var string
     */
    protected $transformerClass = EnrollmentTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'student_id',
        'route_id',
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
            Group::class,
        ]);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
