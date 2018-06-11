<?php

namespace Emtudo\Domains\Calendars\Repositories;

use Emtudo\Domains\Calendars\Contracts\TwoMonthRepository as TwoMonthRepositoryContract;
use Emtudo\Domains\Calendars\Queries\TwoMonthQueryFilter;
use Emtudo\Domains\Calendars\Transformers\TwoMonthTransformer;
use Emtudo\Domains\Calendars\TwoMonth;
use Emtudo\Support\Domain\Repositories\Repository;

class TwoMonthRepository extends Repository implements TwoMonthRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = TwoMonth::class;

    /**
     * @var string
     */
    protected $transformerClass = TwoMonthTransformer::class;

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllTwoMonthsByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new TwoMonthQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }
}
