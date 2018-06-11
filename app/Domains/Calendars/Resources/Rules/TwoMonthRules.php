<?php

namespace Emtudo\Domains\Calendars\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class TwoMonthRules extends Rules
{
    public function defaultRules()
    {
        return [
            'id' => 'required|integer|min:2018|unique:two_months',
            'start1' => 'required|date|date_format:Y-m-d|force_year:id',
            'end1' => 'required|date|after:start1|date_format:Y-m-d|force_year:id',
            'start2' => 'required|date|after:end1|date_format:Y-m-d|force_year:id',
            'end2' => 'required|date|after:start2|date_format:Y-m-d|force_year:id',
            'start3' => 'required|date|after:end2|date_format:Y-m-d|force_year:id',
            'end3' => 'required|date|after:start3|date_format:Y-m-d|force_year:id',
            'start4' => 'required|date|after:end3|date_format:Y-m-d|force_year:id',
            'end4' => 'required|date|after:start4|date_format:Y-m-d|force_year:id',
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
            'id' => 'sometimes|exists:two_months',
        ], $callback);
    }
}
