<?php

namespace Emtudo\Domains\Transports\Repositories;

use Emtudo\Domains\Transports\Contracts\StopRepository as Contract;
use Emtudo\Domains\Transports\Queries\StopQueryFilter;
use Emtudo\Domains\Transports\Stop;
use Emtudo\Domains\Transports\Transformers\StopTransformer;
use Emtudo\Support\Domain\Repositories\Repository;

class StopRepository extends Repository implements Contract
{
    /**
     * @var string
     */
    protected $modelClass = Stop::class;

    /**
     * @var string
     */
    protected $transformerClass = StopTransformer::class;

    public function newQuery()
    {
        return parent::newQuery()->orderBy('label');
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
    public function getAllStopsByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new StopQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }
}
