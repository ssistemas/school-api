<?php

namespace Emtudo\Units\Student\Users\Http\Requests\Teachers;

use Emtudo\Domains\Users\Teacher;
use Emtudo\Support\Http\Request;

class CreateTeacherRequest extends Request
{
    public function rules()
    {
        return Teacher::rules()->creating();
    }
}
