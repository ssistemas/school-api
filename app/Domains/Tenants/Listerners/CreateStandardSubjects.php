<?php

namespace Emtudo\Domains\Courses\Listerners;

use Emtudo\Domains\Courses\Contracts\SubjectRepository;
use Emtudo\Domains\Tenants\Events\TenantCreated;

class CreateStandardSubjects
{
    protected $enrollment;

    /**
     * @param TenantCreated $event
     */
    public function handle(TenantCreated $event)
    {
        $subject = app()->make(SubjectRepository::class);
        $subject->createStandardSubjectsByTenant($event->tenant);
    }
}
