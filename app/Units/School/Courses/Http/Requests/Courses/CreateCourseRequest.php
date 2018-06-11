<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Courses;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Course;

class CreateCourseRequest extends Request
{
    public function rules()
    {
        return Course::rules()->creating();
    }
}
