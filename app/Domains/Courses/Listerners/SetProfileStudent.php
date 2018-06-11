<?php

namespace Emtudo\Domains\Courses\Listerners;

use Emtudo\Domains\Tenants\Events\TenantCreated;
use Emtudo\Domains\Users\Contracts\StudentRepository;

class SetProfileStudent
{
    protected $enrollment;

    /**
     * @param EnrollmentCreated $event
     */
    public function handle(TenantCreated $event)
    {
        $student = app()->make(StudentRepository::class);
        $student->setProfileByEnrollment($event->enrollment->student, $event->enrollment);
    }
}
