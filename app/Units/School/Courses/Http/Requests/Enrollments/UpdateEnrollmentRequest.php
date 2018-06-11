<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Enrollments;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Enrollment;

class UpdateEnrollmentRequest extends Request
{
    public function rules()
    {
        return Enrollment::rules()->updating();
    }
}
