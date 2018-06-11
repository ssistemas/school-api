<?php

namespace Emtudo\Domains\Users\Repositories;

use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Contracts\TeacherRepository as TeacherRepositoryContract;

class TeacherRepository extends UserRepository implements TeacherRepositoryContract
{
    protected $teachersOnly = true;
    protected $adminsOnly = false;
    protected $managersOnly = false;
    protected $responsiblesOnly = false;
    protected $studentsOnly = false;

    public function create(array $data = [])
    {
        $user = parent::create($data);

        if (!$user) {
            return $user;
        }

        $user->tenants()->attach(Tenant::currentTenant(), ['teacher' => true]);

        return $user;
    }

    public function getAllTeachersByParams(array $params, $take = 15, $paginate = true)
    {
        return $this->filtersByParams($params, $take, $paginate);
    }

    public function delete($model, $force = false)
    {
        return $model->tenants()->updateExistingPivot(tenant()->id, ['teacher' => false]);
    }
}
