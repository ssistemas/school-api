<?php

namespace Emtudo\Domains\Courses\Events;

use Emtudo\Domains\Courses\Enrollment;
use Illuminate\Queue\SerializesModels;

class EnrollmentCreated
{
    use SerializesModels;

    /**
     * @var Enrollment
     */
    public $enrollment;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }
}
