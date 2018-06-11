<?php

namespace Emtudo\Domains\Courses\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class QuestionRules extends Rules
{
    public function defaultRules()
    {
        return [
            'quiz_id' => 'required|exists_public_id_by_tenant:quizzes,id',
            'ask' => 'required|string|max:65535',
            'options' => 'nullable|sometimes|array',
            'answer' => 'required|string|max:65535',
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
