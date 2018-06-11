<?php

namespace Emtudo\Domains\Courses\Teachers\Repositories;

use Emtudo\Domains\Courses\Repositories\GradeRepository as Repository;
use Emtudo\Domains\Courses\Teachers\Contracts\GradeRepository as Contract;
use Emtudo\Domains\Courses\Teachers\Grade;
use Emtudo\Domains\Courses\Teachers\Transformers\GradeTransformer;

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
        $query->whereHas('quiz.schedule.skill', function ($query) {
            $user = auth()->user();
            $query->where('teacher_id', $user->id);
        });

        return $query;
    }
}
