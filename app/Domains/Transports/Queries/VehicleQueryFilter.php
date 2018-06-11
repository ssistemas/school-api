<?php

namespace Emtudo\Domains\Transports\Queries;

use Emtudo\Support\Queries\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class VehicleQueryFilter extends BaseQueryBuilder
{
    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    public function getQuery()
    {
        $this->applyLike(['label', 'board', 'driver']);
        $this->applyBetweenIn(['capacity']);
        $this->applyJsonWhere('address');
        $this->applyWhere('id');

        return $this->query;
    }
}
