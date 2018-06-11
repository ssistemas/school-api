<?php

namespace Emtudo\Units\Teacher\Users\Http\Requests\Students;

use Emtudo\Domains\Users\Student;
use Emtudo\Support\Http\Request;

class CreateStudentRequest extends Request
{
    public function rules()
    {
        return Student::rules()->creating();
    }
}
