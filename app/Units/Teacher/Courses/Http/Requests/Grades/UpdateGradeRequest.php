<?php

namespace Emtudo\Units\Teacher\Courses\Http\Requests\Grades;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Grade;

class UpdateGradeRequest extends Request
{
    public function rules()
    {
        return Grade::rules()->updating();
    }
}
