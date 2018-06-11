<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Schedules;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Schedule;

class CreateScheduleRequest extends Request
{
    public function rules()
    {
        return Schedule::rules()->creating();
    }
}
