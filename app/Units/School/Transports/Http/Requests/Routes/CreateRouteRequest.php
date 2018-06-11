<?php

namespace Emtudo\Units\School\Transports\Http\Requests\Routes;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Transports\Route;

class CreateRouteRequest extends Request
{
    public function rules()
    {
        return Route::rules()->creating();
    }
}
