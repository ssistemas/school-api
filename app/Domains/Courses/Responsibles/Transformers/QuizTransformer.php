<?php

namespace Emtudo\Domains\Courses\Responsibles\Transformers;

use Emtudo\Domains\Courses\Quiz;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class QuizTransformer extends Transformer
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
        $completeLabel = $quiz->label.': '.$quiz->schedule->getLabel();

        return [
            'id' => $quiz->publicId(),
            'schedule_id' => $quiz->schedule_id,
            'complete_label' => $completeLabel,

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

        return $this->item($schedule, new ScheduleTransformer());
    }
}
