<?php

namespace Emtudo\Domains\Transports\Repositories;

use Emtudo\Domains\Transports\Contracts\VehicleRepository as Contract;
use Emtudo\Domains\Transports\Queries\VehicleQueryFilter;
use Emtudo\Domains\Transports\Transformers\VehicleTransformer;
use Emtudo\Domains\Transports\Vehicle;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class VehicleRepository extends TenantRepository implements Contract
{
    /**
     * @var string
     */
    protected $modelClass = Vehicle::class;

    /**
     * @var string
     */
    protected $transformerClass = VehicleTransformer::class;

    public function newQuery()
    {
        return parent::newQuery()->orderBy('label');
    }

    public function create(array $data = [])
    {
        $vehicle = parent::create($data);
        if (!$vehicle) {
            return $vehicle;
        }

        $this->syncRoutes($vehicle, $data['routes'] ?? []);

        return $vehicle;
    }

    public function update($model, array $data = [])
    {
        $updated = parent::update($model, $data);
        if (!$updated) {
            return $model;
        }

        $this->syncRoutes($model, $data['routes'] ?? []);

        return $model;
    }

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllVehiclesByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new VehicleQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    protected function syncRoutes(Vehicle $vehicle, array $routes = [])
    {
        return $vehicle->routes()->sync($routes);
    }
}
