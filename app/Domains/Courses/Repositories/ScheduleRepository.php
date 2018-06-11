<?php

namespace Emtudo\Domains\Courses\Repositories;

use Emtudo\Domains\Courses\Contracts\ScheduleRepository as ScheduleRepositoryContract;
use Emtudo\Domains\Courses\Queries\ScheduleQueryFilter;
use Emtudo\Domains\Courses\Schedule;
use Emtudo\Domains\Courses\Transformers\ScheduleTransformer;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class ScheduleRepository extends TenantRepository implements ScheduleRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Schedule::class;

    /**
     * @var string
     */
    protected $transformerClass = ScheduleTransformer::class;

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllSchedulesByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new ScheduleQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    /**
     * get new query on those who are transports.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function newQuery()
    {
        $query = parent::newQuery();

        $query->orderBy('index');

        return $query;
    }
}
