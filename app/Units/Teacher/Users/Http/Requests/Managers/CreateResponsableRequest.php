<?php

namespace Emtudo\Units\Teacher\Users\Http\Requests\Managers;

use Emtudo\Domains\Responsibles\Manager;
use Emtudo\Support\Http\Request;

class CreateResponsibleRequest extends Request
{
    public function rules()
    {
        return Manager::rules()->creating();
    }
}
