<?php

namespace Emtudo\Domains\Tenants\Queries;

use Emtudo\Support\Queries\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class TenantQueryFilter extends BaseQueryBuilder
{
    /**
     * TenantQueryFilter constructor.
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
        $this->byActive();
        $this->byCountryRegister();
        $this->byCity();
        $this->byName();
        $this->byGenericSearchMatch();
        $this->applyWhere('id');
        $this->byDirector();

        return $this->query;
    }

    protected function byActive()
    {
        $active = array_get($this->params, 'active', null);

        if (null === $active) {
            return;
        }

        if (!is_array($active)) {
            $active = [$active];
        }

        $this->query->whereIn('active', $active);
    }

    protected function byCity()
    {
        $city = array_get($this->params, 'city', null);

        if (null === $city) {
            return;
        }

        $this->query->where('address->city', 'like', $city);
    }

    protected function byCountryRegister()
    {
        $country_register = array_get($this->params, 'country_register', null);

        if (!$country_register) {
            return;
        }

        $this->query->where('country_register', $country_register);
    }

    protected function byName()
    {
        $term = array_get($this->params, 'name', null);

        if (!$term) {
            return;
        }

        $this->query->where('name', 'LIKE', "%$term%");
    }

    protected function byDirector()
    {
        $director = array_get($this->params, 'director', null);

        if (!$director) {
            return;
        }

        $this->query->whereHas('director', function ($query) use ($director) {
            $query
                ->select('id')
                ->where('users.name', 'LIKE', '%' . $director . '%');
        });
    }

    protected function byGenericSearchMatch()
    {
        $term = array_get($this->params, 'search', null);

        if (!$term) {
            $term = array_get($this->params, 'q', null);
        }

        if (!$term) {
            return;
        }

        $this->query->where('name', 'LIKE', "%{$term}%")
            ->orWhere('label', 'LIKE', "%{$term}%")
            ->orWhere('country_register', 'LIKE', "%{$term}%");
    }
}
