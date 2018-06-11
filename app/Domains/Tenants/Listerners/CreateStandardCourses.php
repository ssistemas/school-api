<?php

namespace Emtudo\Domains\Courses\Listerners;

use Emtudo\Domains\Courses\Contracts\CourseRepository;
use Emtudo\Domains\Tenants\Events\TenantCreated;

class CreateStandardCourses
{
    protected $enrollment;

    /**
     * @param TenantCreated $event
     */
    public function handle(TenantCreated $event)
    {
        $course = app()->make(CourseRepository::class);
        $course->createStandardCoursesByTenant($event->tenant);
    }
}
