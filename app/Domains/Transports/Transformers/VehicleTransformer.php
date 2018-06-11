<?php

namespace Emtudo\Domains\Transports\Transformers;

use Emtudo\Domains\Transports\Vehicle;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class VehicleTransformer extends Transformer
{
    public $availableIncludes = [
        'routes',
    ];

    /**
     * @param Vehicle $vehicle
     *
     * @return array
     */
    public function transform(Vehicle $vehicle)
    {
        return [
            'id' => $vehicle->publicId(),
            'tenant_id' => encode_id($vehicle->tenant_id),

            'label' => $vehicle->label,
            'board' => $vehicle->board,
            'capacity' => (int) $vehicle->capacity,
        ];
    }

    public function includeRoutes(Vehicle $vehicle)
    {
        $routes = $vehicle->routes;
        if ($routes->isEmpty()) {
            return;
        }

        return $this->collection($routes, new RouteTransformer());
    }
}
