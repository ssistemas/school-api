<?php

namespace Emtudo\Domains\Calendars\Repositories;

use Emtudo\Domains\Calendars\Calendar;
use Emtudo\Domains\Calendars\Contracts\CalendarRepository as CalendarRepositoryContract;
use Emtudo\Domains\Calendars\Queries\CalendarQueryFilter;
use Emtudo\Domains\Calendars\Transformers\CalendarTransformer;
use Emtudo\Support\Domain\Repositories\Repository;

class CalendarRepository extends Repository implements CalendarRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Calendar::class;

    /**
     * @var string
     */
    protected $transformerClass = CalendarTransformer::class;

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
    public function getAllCalendarsByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new CalendarQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }
}
