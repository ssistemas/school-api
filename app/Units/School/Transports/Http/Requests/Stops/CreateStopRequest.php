<?php

namespace Emtudo\Units\School\Transports\Http\Requests\Stops;

use Emtudo\Domains\Transports\Stop;
use Emtudo\Support\Http\Request;

class CreateStopRequest extends Request
{
    public function rules()
    {
        return Stop::rules()->creating();
    }
}
