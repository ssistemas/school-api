<?php

namespace Emtudo\Support\Queries;

use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

abstract class BaseQueryBuilder
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @var EloquentQueryBuilder|QueryBuilder
     */
    protected $query;

    /**
     * @param EloquentQueryBuilder|QueryBuilder $query
     * @param array                             $params
     */
    public function __construct($query, array $params = [])
    {
        $this->params = $params;
        $this->query = $query;
    }

    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    abstract public function getQuery();

    protected function getFieldWithTable($field)
    {
        return $this->query->getModel()->getTable().'.'.$field;
    }

    /**
     * @param array|string $field
     */
    protected function applyLike($field)
    {
        if (is_array($field)) {
            return array_map(function ($item) {
                return $this->applyLike($item);
            }, $field);
        }
        $term = array_get($this->params, $field, null);

        if (!$term) {
            return;
        }

        $this->query->where($this->getFieldWithTable($field), 'LIKE', "%{$term}%");
    }

    protected function applyPeriod($field, $key)
    {
        $period = array_get($this->params, $key, null);

        if (!$period) {
            return;
        }

        if ('morning' === $period) {
            $this->query->whereTime($this->getFieldWithTable($field), '>=', '00:00:00');
            $this->query->whereTime($this->getFieldWithTable($field), '<=', '11:59:59');
        }
        if ('afternoon' === $period) {
            $this->query->whereTime($this->getFieldWithTable($field), '>=', '12:00:00');
            $this->query->whereTime($this->getFieldWithTable($field), '<=', '17:59:59');
        }
        if ('night' === $period) {
            $this->query->whereTime($this->getFieldWithTable($field), '>=', '18:00:00');
            $this->query->whereTime($this->getFieldWithTable($field), '<=', '23:59:59');
        }
    }

    /**
     * @param string $field
     * @param string $queryFilter
     * @param string $fieldId
     */
    protected function applyRelation($field, $queryFilter, $fieldId = 'id')
    {
        $relations = array_get($this->params, $field, []);
        if (empty($relations)) {
            return;
        }

        if (!is_array($relations)) {
            return;
        }

        $this->query->whereHas($field, function ($query) use ($queryFilter, $relations, $field, $fieldId) {
            $query->select($fieldId);

            return (new $queryFilter($query, $relations))->getQuery();
        });
        $this->query->with([$field => function ($query) use ($queryFilter, $relations, $field, $fieldId) {
            return (new $queryFilter($query, $relations))->getQuery();
        }]);
    }

    /**
     * @param array|string $field
     */
    protected function applyWhere($field)
    {
        if (is_array($field)) {
            return array_map(function ($item) {
                $this->applyWhere($item);
            }, $field);
        }
        $term = array_get($this->params, $field, null);

        if (!$term) {
            return;
        }

        $this->query->where($this->getFieldWithTable($field), $term);
    }

    /**
     * @param array|string $field
     */
    protected function applyBetweenIn($field)
    {
        if (is_array($field)) {
            return array_map(function ($item) {
                $this->applyBetweenIn($item);
            }, $field);
        }
        $term = array_get($this->params, $field, []);

        if (!is_array($term) || empty($term)) {
            return;
        }

        if (2 === count($term)) {
            $this->query->whereBetween($this->getFieldWithTable($field), $term);

            return;
        }

        $this->query->where($this->getFieldWithTable($field), $term);
    }

    /**
     * @param array|string $field
     */
    protected function applyBetween($field)
    {
        if (is_array($field)) {
            return array_map(function ($item) {
                $this->applyBetween($item);
            }, $field);
        }
        $term = array_get($this->params, $field, []);

        if (!is_array($term) || 2 !== count($term)) {
            return;
        }

        $this->query->whereBetween($this->getFieldWithTable($field), $term);
    }

    /**
     * @param string $field
     */
    protected function applyJsonLike($field)
    {
        $options = array_get($this->params, $field, []);

        if (!is_array($options)) {
            return;
        }

        array_map(function ($option) use ($field) {
            if (!array_has($option, ['column', 'value'])) {
                return;
            }

            $column = \where_json($field.'->'.$option['column']);
            $table = $this->query->getModel()->getTable();
            $this->query->whereRaw("lower(`{$table}`.{$column}) LIKE ?", ['%'.mb_strtolower($option['value']).'%']);
        }, $options);
    }

    /**
     * @param string $field
     */
    protected function applyJsonWhere($field)
    {
        $options = array_get($this->params, $field, []);

        if (!is_array($options)) {
            return;
        }

        array_map(function ($option) use ($field) {
            if (!array_has($option, ['column', 'value'])) {
                return;
            }

            $this->query->where($this->getFieldWithTable($field.'->'.$option['column']), $option['value']);
        }, $options);
    }
}
