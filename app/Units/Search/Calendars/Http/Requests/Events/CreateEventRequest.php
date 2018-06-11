<?php

namespace Emtudo\Units\Search\Calendars\Http\Requests\Events;

use Emtudo\Domains\Calendars\Event;
use Emtudo\Support\Http\Request;

class CreateEventRequest extends Request
{
    public function rules()
    {
        return Event::rules()->creating();
    }
}
