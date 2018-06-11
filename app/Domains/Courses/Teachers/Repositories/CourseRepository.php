<?php

namespace Emtudo\Domains\Courses\Teachers\Repositories;

use Emtudo\Domains\Courses\Repositories\CourseRepository as Repository;
use Emtudo\Domains\Courses\Teachers\Contracts\CourseRepository as Contract;
use Emtudo\Domains\Courses\Teachers\Course;
use Emtudo\Domains\Courses\Teachers\Transformers\CourseTransformer;

class CourseRepository extends Repository implements Contract
{
    /**
     * @var string
     */
    protected $modelClass = Course::class;

    /**
     * @var string
     */
    protected $transformerClass = CourseTransformer::class;

    public function newQuery()
    {
        $query = parent::newQuery()->orderBy('label');
        $query->whereHas('groups.enrollments', function ($query) {
            $user = auth()->user();
            $query->where('student_id', $user->id);
        });

        return $query;
    }
}
