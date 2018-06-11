<?php

namespace Emtudo\Units\School\Transports\Http\Requests\Vehicles;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Transports\Vehicle;

class UpdateVehicleRequest extends Request
{
    public function rules()
    {
        return Vehicle::rules()->updating();
    }
}
