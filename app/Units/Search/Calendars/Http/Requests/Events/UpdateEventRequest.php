<?php

namespace Emtudo\Units\Search\Calendars\Http\Requests\Events;

use Emtudo\Domains\Calendars\Event;
use Emtudo\Support\Http\Request;

class UpdateEventRequest extends Request
{
    public function rules()
    {
        return Event::rules()->updating();
    }
}
