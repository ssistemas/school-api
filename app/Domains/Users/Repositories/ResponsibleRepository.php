<?php

namespace Emtudo\Domains\Users\Repositories;

use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Contracts\ResponsibleRepository as ResponsibleRepositoryContract;

class ResponsibleRepository extends UserRepository implements ResponsibleRepositoryContract
{
    protected $responsiblesOnly = true;
    protected $adminsOnly = false;
    protected $managersOnly = false;
    protected $studentsOnly = false;
    protected $teachersOnly = false;

    public function create(array $data = [])
    {
        $user = parent::create($data);

        if (!$user) {
            return $user;
        }

        $user->tenants()->attach(Tenant::currentTenant(), ['responsible' => true]);

        return $user;
    }

    public function getAllResponsiblesByParams(array $params, $take = 15, $paginate = true)
    {
        return $this->filtersByParams($params, $take, $paginate);
    }

    public function delete($model, $force = false)
    {
        return $model->tenants()->updateExistingPivot(tenant()->id, ['responsible' => false]);
    }
}
