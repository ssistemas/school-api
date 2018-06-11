<?php

namespace Emtudo\Units\School\Calendars\Http\Requests\Events;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Calendars\Event;

class UpdateEventRequest extends Request
{
    public function rules()
    {
        return Event::rules()->updating();
    }
}
