<?php

namespace Emtudo\Domains\Courses\Students\Repositories;

use Emtudo\Domains\Courses\Repositories\GroupRepository as Repository;
use Emtudo\Domains\Courses\Students\Contracts\GroupRepository as Contract;
use Emtudo\Domains\Courses\Students\Group;
use Emtudo\Domains\Courses\Students\Transformers\GroupTransformer;

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
        $query->whereHas('enrollments', function ($query) {
            $user = auth()->user();
            $query->where('student_id', $user->id);
        });

        return $query;
    }
}
