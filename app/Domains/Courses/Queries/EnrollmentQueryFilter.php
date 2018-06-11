<?php

namespace Emtudo\Domains\Courses\Queries;

use Emtudo\Support\Queries\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class EnrollmentQueryFilter extends BaseQueryBuilder
{
    /**
     * @param EloquentQueryBuilder|QueryBuilder $query
     * @param array                             $params
     */
    public function __construct($query, array $params)
    {
        $this->params = $params;
        $this->query = $query;
    }

    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    public function getQuery()
    {
        $this->applyWhere(['id', 'student_id', 'group_id', 'route_id']);

        return $this->query;
    }
}
