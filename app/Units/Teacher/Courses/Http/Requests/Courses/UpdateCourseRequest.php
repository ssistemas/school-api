<?php

namespace Emtudo\Units\Teacher\Courses\Http\Requests\Courses;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Course;

class UpdateCourseRequest extends Request
{
    public function rules()
    {
        return Course::rules()->updating();
    }
}
