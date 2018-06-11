<?php

namespace Emtudo\Units\Settings\Http\Requests;

use Emtudo\Domains\Users\User;
use Emtudo\Support\Http\Request;

class DocumentRequest extends Request
{
    public function rules()
    {
        return User::rules()->document();
    }
}
