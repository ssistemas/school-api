<?php

namespace Emtudo\Domains\Courses\Teachers\Repositories;

use Emtudo\Domains\Courses\Repositories\GroupRepository as Repository;
use Emtudo\Domains\Courses\Teachers\Contracts\GroupRepository as Contract;
use Emtudo\Domains\Courses\Teachers\Group;
use Emtudo\Domains\Courses\Teachers\Transformers\GroupTransformer;

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
        $query->whereHas('schedules.skill', function ($query) {
            $user = auth()->user();
            $query->where('teacher_id', $user->id);
        });

        return $query;
    }
}
