<?php

namespace Emtudo\Domains\Calendars\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class CalendarRules extends Rules
{
    public function defaultRules()
    {
        return [
            'year' => 'required|integer|min:2018|max:2099',
            'label' => 'required|string|max:255',
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
