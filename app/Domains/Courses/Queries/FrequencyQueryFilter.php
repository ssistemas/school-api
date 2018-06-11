<?php

namespace Emtudo\Domains\Courses\Queries;

use Emtudo\Domains\Users\Queries\UserQueryFilter;
use Emtudo\Support\Queries\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class FrequencyQueryFilter extends BaseQueryBuilder
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
        $this->applyWhere(['present', 'justified_absence']);
        $this->applyRelation('subject', SubjectQueryFilter::class);
        $this->applyRelation('student', UserQueryFilter::class);

        return $this->query;
    }
}
