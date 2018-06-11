<?php

namespace Emtudo\Domains\Courses\Transformers;

use Emtudo\Domains\Courses\Grade;
use Emtudo\Domains\Users\Transformers\StudentTransformer;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class GradeTransformer extends Transformer
{
    public $availableIncludes = [
        'student',
        'quiz',
        'short_quiz',
    ];

    /**
     * @param Grade $grade
     *
     * @return array
     */
    public function transform(Grade $grade)
    {
        return [
            'id' => $grade->publicId(),
            'student_id' => encode_id($grade->student_id),
            'quiz_id' => encode_id($grade->quiz_id),
            'value' => (float) $grade->value,
        ];
    }

    public function includeStudent(Grade $grade)
    {
        return $this->item($grade->student, new StudentTransformer());
    }

    public function includeQuiz(Grade $grade)
    {
        return $this->item($grade->quiz, new QuizTransformer());
    }

    public function includeShortQuiz(Grade $grade)
    {
        return $this->item($grade->quiz, new QuizShortTransformer());
    }
}
