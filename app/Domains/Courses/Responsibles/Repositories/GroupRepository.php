<?php

namespace Emtudo\Domains\Courses\Responsibles\Repositories;

use Emtudo\Domains\Courses\Repositories\GroupRepository as Repository;
use Emtudo\Domains\Courses\Responsibles\Contracts\GroupRepository as Contract;
use Emtudo\Domains\Courses\Responsibles\Group;
use Emtudo\Domains\Courses\Responsibles\Transformers\GroupTransformer;

class GroupRepository extends Repository implements Contract
{
    /**
     * @var string
     */
    protected $modelClass = Group::class;

    /**
     * @var string
     */
    protected $transformerClass = GroupTransformer::class;

    public function newQuery()
    {
        $query = parent::newQuery()->orderBy('label');
        $query->whereHas('enrollments.student', function ($query) {
            $userId = auth()->user()->id;
            $query
                ->where('users.parent1_id', $userId)
                ->orWhere('users.parent2_id', $userId)
                ->orWhere('users.responsible1_id', $userId)
                ->orWhere('users.responsible2_id', $userId);
        });

        return $query;
    }
}
