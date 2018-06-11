<?php

namespace Emtudo\Domains\Courses\Transformers;

use Emtudo\Domains\Courses\Grade;
use Emtudo\Domains\Users\Transformers\StudentNameTransformer;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class GradeAverageTransformer extends Transformer
{
    public $defaultIncludes = [
        'student',
    ];

    /**
     * @param Grade $grade
     *
     * @return array
     */
    public function transform(Grade $grade)
    {
        return [
            'grade' => $grade->grade,
        ];
    }

    public function includeStudent(Grade $grade)
    {
        return $this->item($grade->student, new StudentNameTransformer());
    }
}
