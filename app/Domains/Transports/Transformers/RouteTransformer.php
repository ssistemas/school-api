<?php

namespace Emtudo\Domains\Transports\Transformers;

use Emtudo\Domains\Transports\Route;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class RouteTransformer extends Transformer
{
    public $availableIncludes = [
        'stops',
        'vehicles',
    ];

    /**
     * @param Route $route
     *
     * @return array
     */
    public function transform(Route $route)
    {
        $transform = [
            'id' => $route->publicId(),
            'tenant_id' => encode_id($route->tenant_id),

            'label' => $route->label,
        ];

        $driver = $route->pivot->driver ?? null;
        if ($driver) {
            $transform['driver'] = $driver;
        }

        return $transform;
    }

    public function includeStops(Route $route)
    {
        $stops = $route->stops;
        if ($stops->isEmpty()) {
            return;
        }

        return $this->collection($stops, new StopTransformer());
    }

    public function includeVehicles(Route $route)
    {
        $vehicles = $route->vehicles;
        if ($vehicles->isEmpty()) {
            return;
        }

        return $this->collection($vehicles, new VehicleTransformer());
    }
}
