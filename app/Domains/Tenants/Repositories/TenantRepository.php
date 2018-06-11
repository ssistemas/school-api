<?php

namespace Emtudo\Domains\Tenants\Repositories;

use Emtudo\Domains\Tenants\Contracts\TenantRepository as TenantRepositoryContract;
use Emtudo\Domains\Tenants\Queries\TenantQueryFilter;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Tenants\Transformers\TenantTransformer;
use Emtudo\Support\Domain\Repositories\Repository;

class TenantRepository extends Repository implements TenantRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Tenant::class;

    /**
     * @var string
     */
    protected $transformerClass = TenantTransformer::class;

    public function newQuery()
    {
        return parent::newQuery()->orderBy('name');
    }

    public function setModelData($model, array $data)
    {
        parent::setModelData($model, $data);

        if (isset($data['active'])) {
            $model->active = (bool) $data['active'];
        }
    }

    public function getAll($take = 15, $paginate = true)
    {
        $query = $this->newQuery()->orderBy('name');

        return $this->doQuery($query, $take, $paginate);
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
    public function getAllTenantsByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new TenantQueryFilter($this->newTenantQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    /**
     * get new query on those who are tenants.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    protected function newTenantQuery()
    {
        return $this->newQuery();
    }
}
