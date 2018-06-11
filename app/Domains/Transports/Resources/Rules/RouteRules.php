<?php

namespace Emtudo\Domains\Transports\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class RouteRules extends Rules
{
    public function defaultRules()
    {
        return [
            'label' => 'required|string|max:60|unique:routes',
            'stops' => 'required|array',
            'stop.*.label' => 'required|string|max:60',
            'stop.*.stop_id' => 'required|exists_public_id:stops,id',
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
