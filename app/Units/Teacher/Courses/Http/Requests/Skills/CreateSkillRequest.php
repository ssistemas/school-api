<?php

namespace Emtudo\Units\Teacher\Courses\Http\Requests\Skills;

use Emtudo\Domains\Courses\Skill;
use Emtudo\Support\Http\Request;

class CreateSubjectRequest extends Request
{
    public function rules()
    {
        return Skill::rules()->creating();
    }
}
