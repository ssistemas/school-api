<?php

namespace Emtudo\Domains\Courses\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class CourseRules extends Rules
{
    public function defaultRules()
    {
        return [
            'label' => 'required|string|max:60',
            'min_frequency' => 'required|integer|min:1|max:100',
            'min_grade' => 'required|integer|min:1|max:100',

            //'max_period' => 'nullable|sometimes|integer|min:1|max:12',
            //'division_period' => 'nullable|sometimes|integer|min:1|max:12',
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
