<?php

namespace Emtudo\Domains\Transports\Repositories;

use Emtudo\Domains\Transports\Contracts\RouteRepository as Contract;
use Emtudo\Domains\Transports\Queries\RouteQueryFilter;
use Emtudo\Domains\Transports\Route;
use Emtudo\Domains\Transports\Transformers\RouteTransformer;
use Emtudo\Support\Domain\Repositories\Repository;

class RouteRepository extends Repository implements Contract
{
    /**
     * @var string
     */
    protected $modelClass = Route::class;

    /**
     * @var string
     */
    protected $transformerClass = RouteTransformer::class;

    public function newQuery()
    {
        return parent::newQuery()->orderBy('label');
    }

    public function create(array $data = [])
    {
        $route = parent::create($data);
        if (!$route) {
            return $route;
        }

        $this->syncStops($route, $data['stops'] ?? []);

        return $route;
    }

    public function update($model, array $data = [])
    {
        $updated = parent::update($model, $data);
        if (!$updated) {
            return $model;
        }

        $this->syncStops($model, $data['stops'] ?? []);

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
    public function getAllRoutesByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new RouteQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    protected function syncStops(Route $route, array $stops = [])
    {
        return $route->stops()->sync($stops);
    }
}
