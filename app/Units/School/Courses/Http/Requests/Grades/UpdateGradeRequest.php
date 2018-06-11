<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Grades;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Grade;

class UpdateGradeRequest extends Request
{
    public function rules()
    {
        return Grade::rules()->updating();
    }
}
