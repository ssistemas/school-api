<?php

namespace Emtudo\Domains\Transports\Database\Factories;

use Emtudo\Domains\Transports\Vehicle;
use Emtudo\Support\Domain\Database\ModelFactory;

class VehicleFactory extends ModelFactory
{
    protected $model = Vehicle::class;

    public function fields()
    {
        return [
        ];
    }
}
