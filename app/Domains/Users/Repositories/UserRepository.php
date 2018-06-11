<?php

namespace Emtudo\Domains\Users\Repositories;

use Emtudo\Domains\Users\Contracts\UserRepository as UserRepositoryContract;
use Emtudo\Domains\Users\Queries\UserQueryFilter;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Domain\Repositories\Repository;

class UserRepository extends Repository implements UserRepositoryContract
{
    use Traits\NewUserQueryTrait;
    use Traits\OnlyTrait;

    protected $modelClass = User::class;

    protected $adminsOnly = false;
    protected $managersOnly = false;
    protected $responsiblesOnly = false;
    protected $studentsOnly = false;
    protected $teachersOnly = false;

    protected $schoolOnly = true;

    public function setModelData($model, array $data)
    {
        parent::setModelData($model, $data);

        if (isset($data['password']) && !empty($data['password'])) {
            $model->password = $data['password'];
        }
    }

    public function newQuery()
    {
        $query = parent::newQuery()->orderBy('name');

        $user = auth()->user();

        if ($this->schoolOnly && !$user->isAdmin()) {
            $query->whereHas('tenants', function ($query) {
                return $query->where('id', tenant()->id);
            });
        }

        return $query;
    }

    public function getAllUsersByParams(array $params, $take = 15, $paginate = true)
    {
        return $this->filtersByParams($params, $take, $paginate);
    }

    public function attachProfiles(User $user, $profiles)
    {
        $user->tenants()->syncWithoutDetaching([tenant()->id => $profiles]);

        return $user;
    }

    public function count()
    {
        return $this->newUserQuery()->count();
    }

    public function exists()
    {
        return $this->newUserQuery()->exists();
    }

    public function getBirthdays(string $when = 'today', $take = 15, $paginate = true)
    {
        $query = $this->newUserQuery();
        $query = (new UserQueryFilter($this->newUserQuery(), []))->getBirthdays($when);

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
    protected function filtersByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new UserQueryFilter($this->newUserQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    /**
     * get new query on those who are tenants.
     *
     * @param string $type
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    protected function newQueryFilterUserByType(string $type)
    {
        return $this->newQuery()
            ->whereHas('tenants', function ($query) use ($type) {
                $query->where($type, true);
            });
    }
}
