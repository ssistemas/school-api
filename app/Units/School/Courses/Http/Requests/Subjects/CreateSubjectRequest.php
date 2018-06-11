<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Subjects;

use Emtudo\Domains\Courses\Subject;
use Emtudo\Support\Http\Request;

class CreateSubjectRequest extends Request
{
    public function rules()
    {
        return Subject::rules()->creating();
    }
}
