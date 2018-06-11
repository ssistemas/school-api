<?php

namespace Emtudo\Domains\Courses\Queries;

use Emtudo\Support\Queries\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class GroupQueryFilter extends BaseQueryBuilder
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
        $this->applyLike('label');
        $this->applyBetweenIn([
            'perid', 'max_students', 'pass_score', 'year', 'course_id',
        ]);
        $this->applyWhere('year');
        $this->bySubjectId();

        return $this->query;
    }

    protected function bySubjectId()
    {
        $subjectId = array_get($this->params, 'subject_id', null);

        if (null === $subjectId) {
            return;
        }

        $this->query->whereHas('subjects', function ($query) use ($subjectId) {
            return $query->where('subject_id', $subjectId);
        });
    }
}
