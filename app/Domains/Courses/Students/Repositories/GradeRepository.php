<?php

namespace Emtudo\Domains\Courses\Students\Repositories;

use Emtudo\Domains\Courses\Repositories\GradeRepository as Repository;
use Emtudo\Domains\Courses\Students\Contracts\GradeRepository as Contract;
use Emtudo\Domains\Courses\Students\Grade;
use Emtudo\Domains\Courses\Students\Transformers\GradeTransformer;

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
        $user = auth()->user();
        $query = parent::newQuery();
        $query->where('grades.student_id', $user->id);

        return $query;
    }
}
