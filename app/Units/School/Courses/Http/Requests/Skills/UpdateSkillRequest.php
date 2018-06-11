<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Skills;

use Emtudo\Domains\Courses\Skill;
use Emtudo\Support\Http\Request;

class UpdateSubjectRequest extends Request
{
    public function rules()
    {
        return Skill::rules()->updating();
    }
}
