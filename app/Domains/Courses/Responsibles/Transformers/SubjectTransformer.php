<?php

namespace Emtudo\Domains\Courses\Responsibles\Transformers;

use Emtudo\Domains\Courses\Subject;
use Emtudo\Domains\Users\Transformers\UserLabelTransformer;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class SubjectTransformer extends Transformer
{
    public $availableIncludes = [
        'teachers',
    ];

    /**
     * @param Subject $subject
     *
     * @return array
     */
    public function transform(Subject $subject)
    {
        return [
            'id' => $subject->publicId(),
            // 'tenant_id' => encode_id($subject->tenant_id),

            'label' => $subject->label,

            // 'pass_score' => $subject->pass_score ? (float) $subject->pass_score : null,
        ];
    }

    public function includeTeachers(Subject $subject)
    {
        $teachers = $subject->teachers;
        if ($teachers->isEmpty()) {
            return;
        }

        return $this->collection($teachers, new UserLabelTransformer());
    }
}
