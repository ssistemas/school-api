<?php

namespace Emtudo\Units\School\Users\Http\Requests\Responsibles;

use Emtudo\Domains\Responsibles\Responsible;
use Emtudo\Support\Http\Request;

class CreateResponsibleRequest extends Request
{
    public function rules()
    {
        return Responsible::rules()->creating();
    }
}
