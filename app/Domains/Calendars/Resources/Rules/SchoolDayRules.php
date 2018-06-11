<?php

namespace Emtudo\Domains\Calendars\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class SchoolDayRules extends Rules
{
    public function defaultRules()
    {
        return [
            'date' => 'required|date|date_format:Y-m-d',
            'label' => 'nullable|sometimes|string|max:255',
            'school_day' => 'sometimes|boolean',
        ];
    }

    public function creating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }

    public function toggle($callback = null)
    {
        $rules = [
            'date' => 'required|date|date_format:Y-m-d|exists:school_days',
        ];
        if (is_callable($callback)) {
            return $callback($rules);
        }

        return $rules;
    }

    public function updating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }
}
