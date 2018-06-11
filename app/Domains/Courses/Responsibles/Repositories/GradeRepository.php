<?php

namespace Emtudo\Domains\Courses\Responsibles\Repositories;

use Emtudo\Domains\Courses\Repositories\GradeRepository as Repository;
use Emtudo\Domains\Courses\Responsibles\Contracts\GradeRepository as Contract;
use Emtudo\Domains\Courses\Responsibles\Grade;
use Emtudo\Domains\Courses\Responsibles\Transformers\GradeTransformer;

class GradeRepository extends Repository implements Contract
{
    /**
     * @var string
     */
    protected $modelClass = Grade::class;

    /**
     * @var string
     */
    protected $transformerClass = GradeTransformer::class;

    public function newQuery()
    {
        $query = parent::newQuery();
        $query->whereHas('student', function ($query) {
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
