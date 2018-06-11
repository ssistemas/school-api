<?php

namespace Emtudo\Domains\Users\Repositories;

use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Contracts\ManagerRepository as ManagerRepositoryContract;

class ManagerRepository extends UserRepository implements ManagerRepositoryContract
{
    protected $managersOnly = true;
    protected $adminsOnly = false;
    protected $studentsOnly = false;
    protected $responsiblesOnly = false;
    protected $teachersOnly = false;

    public function create(array $data = [])
    {
        $user = parent::create($data);

        if (!$user) {
            return $user;
        }

        $user->tenants()->attach(Tenant::currentTenant(), ['manager' => true]);

        return $user;
    }

    public function getAllManagersByParams(array $params, $take = 15, $paginate = true)
    {
        return $this->filtersByParams($params, $take, $paginate);
    }

    public function delete($model, $force = false)
    {
        return $model->tenants()->updateExistingPivot(tenant()->id, ['manager' => false]);
    }
}
