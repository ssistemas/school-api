<?php

namespace Emtudo\Domains\Courses\Repositories;

use Emtudo\Domains\Courses\Contracts\SkillRepository as SkillRepositoryContract;
use Emtudo\Domains\Courses\Queries\SkillQueryFilter;
use Emtudo\Domains\Courses\Skill;
use Emtudo\Domains\Courses\Transformers\SkillTransformer;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class SkillRepository extends TenantRepository implements SkillRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Skill::class;

    /**
     * @var string
     */
    protected $transformerClass = SkillTransformer::class;

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllSkillsByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new SkillQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    /**
     * get new query on those who are transports.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function newQuery()
    {
        $query = parent::newQuery();

        $user = auth()->user();
        if ($user->is_admin) {
            return $query;
        }

        $query->where('teacher_id', $user->id)
            ->where('tenant_id', tenant()->id);

        return $query;
    }
}
