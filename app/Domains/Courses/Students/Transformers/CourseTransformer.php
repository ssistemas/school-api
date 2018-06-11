<?php

namespace Emtudo\Domains\Courses\Students\Transformers;

use Emtudo\Domains\Courses\Course;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class CourseTransformer extends Transformer
{
    /**
     * @param Course $course
     *
     * @return array
     */
    public function transform(Course $course)
    {
        return [
            'id' => $course->publicId(),
            'tenant_id' => encode_id($course->tenant_id),
            'label' => $course->label,
            'max_period' => $course->max_period ? (int) $course->max_period : null,
            'division_period' => $course->division_period ? (int) $course->division_period : null,
        ];
    }
}
