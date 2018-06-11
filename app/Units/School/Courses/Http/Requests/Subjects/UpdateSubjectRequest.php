<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Subjects;

use Emtudo\Domains\Courses\Subject;
use Emtudo\Support\Http\Request;

class UpdateSubjectRequest extends Request
{
    public function rules()
    {
        return Subject::rules()->updating();
    }
}
