<?php

namespace Emtudo\Domains\Transports\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class VehicleRules extends Rules
{
    public function defaultRules()
    {
        return [
            'label' => 'required|string|max:60',
            'board' => 'required|string|max:8',
            'capacity' => 'required|integer|min:1|max:100',
            'routes' => 'required|array',
            'routes.*.route_id' => 'required|exists_public_id:routes,id',
            'routes.*.driver' => 'required|string|max:50',
        ];
    }

    public function creating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }

    public function updating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }
}
