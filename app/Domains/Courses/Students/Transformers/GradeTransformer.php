<?php

namespace Emtudo\Domains\Courses\Students\Transformers;

use Emtudo\Domains\Courses\Grade;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class GradeTransformer extends Transformer
{
    public $availableIncludes = [
    ];

    /**
     * @param Grade $grade
     *
     * @return array
     */
    public function transform(Grade $grade)
    {
        return [
            'absence' => (int) $grade->absence,
            'grade' => (float) $grade->grade,
            'justified_absence' => (int) $grade->justified_absence,
            'percent' => round(($grade->present * 100 / ($grade->absence + $grade->present)), 2),
            'present' => (int) $grade->present,
            'subject' => $grade->subject,
            'subject_id' => encode_id($grade->subject_id),
        ];
    }
}
