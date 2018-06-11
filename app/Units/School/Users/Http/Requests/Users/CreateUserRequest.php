<?php

namespace Emtudo\Units\School\Users\Http\Requests\Users;

use Emtudo\Domains\Users\User;
use Emtudo\Support\Http\Request;

class CreateUserRequest extends Request
{
    public function rules()
    {
        return User::rules()->creating();
    }
}
