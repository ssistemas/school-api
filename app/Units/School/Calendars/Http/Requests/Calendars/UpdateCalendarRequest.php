<?php

namespace Emtudo\Units\School\Calendars\Http\Requests\Calendars;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Calendars\Calendar;

class UpdateCalendarRequest extends Request
{
    public function rules()
    {
        return Calendar::rules()->updating();
    }
}
