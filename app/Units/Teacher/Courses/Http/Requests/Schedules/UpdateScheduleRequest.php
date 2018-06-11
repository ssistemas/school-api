<?php

namespace Emtudo\Units\Teacher\Courses\Http\Requests\Schedules;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Schedule;

class UpdateScheduleRequest extends Request
{
    public function rules()
    {
        return Schedule::rules()->updating();
    }
}
