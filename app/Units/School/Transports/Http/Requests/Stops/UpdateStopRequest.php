<?php

namespace Emtudo\Units\School\Transports\Http\Requests\Stops;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Transports\Stop;

class UpdateStopRequest extends Request
{
    public function rules()
    {
        return Stop::rules()->updating();
    }
}
