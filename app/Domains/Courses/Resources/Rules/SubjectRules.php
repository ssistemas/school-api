<?php

namespace Emtudo\Domains\Courses\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class SubjectRules extends Rules
{
    public function defaultRules()
    {
        return [
            'label' => 'required|string|max:255',
            'pass_score' => 'nullable|sometimes|numeric|between:0,100',
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
