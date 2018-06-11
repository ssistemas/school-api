<?php

namespace Emtudo\Domains\Calendars\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class EventRules extends Rules
{
    public function defaultRules()
    {
        return [
            'label' => 'required|string|max:255',
            'date' => 'required|date|date_format:Y-m-d H:i:s',
            'description' => 'nullable|sometimes|string|max:65535',
            'address' => 'nullable|sometimes|array',
            'address.street' => 'required|string|max:60',
            'address.number' => 'required|string|max:10',
            'address.city' => 'required|string|max:60',
            'address.district' => 'required|string|max:60',
            'address.zip' => 'required|string|max:8',
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
