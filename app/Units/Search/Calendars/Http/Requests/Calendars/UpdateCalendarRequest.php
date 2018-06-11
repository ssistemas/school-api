<?php

namespace Emtudo\Units\Search\Calendars\Http\Requests\Calendars;

use Emtudo\Domains\Calendars\Calendar;
use Emtudo\Support\Http\Request;

class UpdateCalendarRequest extends Request
{
    public function rules()
    {
        return Calendar::rules()->updating();
    }
}
