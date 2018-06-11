<?php

namespace Emtudo\Domains\Courses\Queries;

use Emtudo\Domains\Users\Queries\UserQueryFilter;
use Emtudo\Support\Queries\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class GradeQueryFilter extends BaseQueryBuilder
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
        $this->applyWhere('student_id');
        $this->applyWhere('quiz_id');
        $this->applyBetweenIn('value');
        $this->applyRelation('quiz', QuizQueryFilter::class);
        $this->applyRelation('student', UserQueryFilter::class);

        return $this->query;
    }
}
