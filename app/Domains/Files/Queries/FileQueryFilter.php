<?php

namespace Emtudo\Domains\Files\Queries;

use Emtudo\Support\Queries\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class FileQueryFilter extends BaseQueryBuilder
{
    /**
     * FileQueryFilter constructor.
     *
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
        $this->byGroups();

        return $this->query;
    }

    protected function byGroups()
    {
        $group = array_get($this->params, 'group', null);

        if (!$group) {
            return;
        }

        $this->query->where('fileable_type', $group);
    }
}
