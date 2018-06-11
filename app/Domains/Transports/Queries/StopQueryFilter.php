<?php

namespace Emtudo\Domains\Transports\Queries;

use Emtudo\Support\Queries\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class StopQueryFilter extends BaseQueryBuilder
{
    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    public function getQuery()
    {
        $this->applyLike('label');
        $this->applyJsonLike('address');
        $this->applyWhere('id');

        return $this->query;
    }
}
