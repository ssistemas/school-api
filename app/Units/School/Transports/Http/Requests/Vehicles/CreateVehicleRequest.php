<?php

namespace Emtudo\Units\School\Transports\Http\Requests\Vehicles;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Transports\Vehicle;

class CreateVehicleRequest extends Request
{
    public function rules()
    {
        return Vehicle::rules()->creating();
    }
}
