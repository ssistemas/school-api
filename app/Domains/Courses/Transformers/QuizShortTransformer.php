<?php

namespace Emtudo\Domains\Courses\Transformers;

use Emtudo\Domains\Courses\Quiz;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class QuizShortTransformer extends Transformer
{
    public $availableIncludes = [
        'schedule',
    ];

    /**
     * @param Quiz $quiz
     *
     * @return array
     */
    public function transform(Quiz $quiz)
    {
        return [
            'id' => $quiz->publicId(),
            'label' => $quiz->label,
            'score' => $quiz->score ? (int) $quiz->score : null,
            'date' => $quiz->getOriginal('date'),
            'kind' => $quiz->kind,
            'proof_of_recovery' => (bool) (int) $quiz->proof_of_recovery,
        ];
    }

    public function includeSchedule(Quiz $quiz)
    {
        $schedule = $quiz->schedule;
        if (!$schedule) {
            return;
        }

        return $this->item($schedule, new ScheduleShortTransformer());
    }
}
