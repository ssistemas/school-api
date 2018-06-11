<?php

namespace Emtudo\Domains\Courses\Teachers\Repositories;

use Emtudo\Domains\Courses\Repositories\QuizRepository as Repository;
use Emtudo\Domains\Courses\Teachers\Contracts\QuizRepository as Contract;
use Emtudo\Domains\Courses\Teachers\Quiz;
use Emtudo\Domains\Courses\Teachers\Transformers\QuizTransformer;

class QuizRepository extends Repository implements Contract
{
    /**
     * @var string
     */
    protected $modelClass = Quiz::class;

    /**
     * @var string
     */
    protected $transformerClass = QuizTransformer::class;

    public function newQuery()
    {
        $query = parent::newQuery();
        $query->whereHas('schedule.skill', function ($query) {
            $user = auth()->user();
            $query->where('teacher_id', $user->id);
        });

        return $query;
    }
}
