<?php

namespace Emtudo\Domains\Courses\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class QuizRules extends Rules
{
    public function defaultRules()
    {
        return [
            'schedule_id' => 'required|exists:schedules,id',
            'kind' => 'required|in:proof,work,cultural_fair,others',
            'label' => 'required|string|max:255',
            'score' => 'required|integer|min:1|max:100',
            'date' => 'bail|required|date|date_format:Y-m-d|exists_school_day:school_days,date',
        ];
    }

    public function creating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }

    public function updating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }
}
