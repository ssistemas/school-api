<?php

namespace Emtudo\Units\Teacher\Courses\Http\Requests\Groups;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Group;

class UpdateGroupRequest extends Request
{
    public function rules()
    {
        return Group::rules()->updating();
    }
}
