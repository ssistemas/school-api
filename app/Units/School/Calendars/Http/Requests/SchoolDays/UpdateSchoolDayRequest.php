<?php

namespace Emtudo\Units\School\Calendars\Http\Requests\SchoolDays;

use Emtudo\Domains\Calendars\SchoolDay;
use Emtudo\Support\Http\Request;

class UpdateSchoolDayRequest extends Request
{
    public function rules()
    {
        return SchoolDay::rules()->updating();
    }
}
