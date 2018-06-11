<?php

namespace Emtudo\Domains\Calendars\Repositories;

use Emtudo\Domains\Calendars\Contracts\EventRepository as EventRepositoryContract;
use Emtudo\Domains\Calendars\Event;
use Emtudo\Domains\Calendars\Queries\EventQueryFilter;
use Emtudo\Domains\Calendars\Transformers\EventTransformer;
use Emtudo\Support\Domain\Repositories\Repository;

class EventRepository extends Repository implements EventRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Event::class;

    /**
     * @var string
     */
    protected $transformerClass = EventTransformer::class;

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
    public function getAllEventsByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new EventQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }
}
