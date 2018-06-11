<?php

namespace Emtudo\Domains\Users\Repositories;

use Emtudo\Domains\Users\Contracts\AdminRepository as AdminRepositoryContract;

class AdminRepository extends UserRepository implements AdminRepositoryContract
{
    protected $adminsOnly = true;
    protected $managersOnly = false;
    protected $responsiblesOnly = false;
    protected $studentsOnly = false;
    protected $teachersOnly = false;

    public function create(array $data = [])
    {
        $user = parent::create($data);

        if (!$user) {
            return $user;
        }

        $user->is_admin = true;
        $user->save();

        return $user;
    }

    public function getAllAdminsByParams(array $params, $take = 15, $paginate = true)
    {
        return $this->filtersByParams($params, $take, $paginate);
    }
}
