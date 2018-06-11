<?php

namespace Emtudo\Domains\Courses\Teachers\Repositories;

use Emtudo\Domains\Courses\Repositories\SubjectRepository as Repository;
use Emtudo\Domains\Courses\Teachers\Contracts\SubjectRepository as Contract;
use Emtudo\Domains\Courses\Teachers\Subject;
use Emtudo\Domains\Courses\Teachers\Transformers\SubjectTransformer;

class SubjectRepository extends Repository implements Contract
{
    /**
     * @var string
     */
    protected $modelClass = Subject::class;

    /**
     * @var string
     */
    protected $transformerClass = SubjectTransformer::class;

    public function newQuery()
    {
        $query = parent::newQuery();
        $query->whereHas('teachers', function ($query) {
            $user = auth()->user();
            $query->where('teacher_id', $user->id);
        });

        return $query;
    }
}
