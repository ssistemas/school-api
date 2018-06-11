<?php

namespace Emtudo\Domains\Courses\Transformers;

use Emtudo\Domains\Courses\Frequency;
use Emtudo\Domains\Users\Transformers\StudentNameTransformer;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class FrequencyTopAbsenceTransformer extends Transformer
{
    public $defaultIncludes = [
        'student',
    ];

    /**
     * @param Frequency $frequency
     *
     * @return array
     */
    public function transform(Frequency $frequency)
    {
        return [
            'absences' => (int) $frequency->absences,
        ];
    }

    public function includeStudent(Frequency $frequency)
    {
        $student = $frequency->student;

        if (!$student) {
            return;
        }

        return $this->item($student, new StudentNameTransformer());
    }
}
