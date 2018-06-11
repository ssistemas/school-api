<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Frequencies;

use Emtudo\Domains\Courses\Frequency;
use Emtudo\Domains\Courses\Schedule;
use Emtudo\Support\Http\Request;

class CreateFrequencySeveralRequest extends Request
{
    public function rules()
    {
        return Frequency::rules()->several(function ($rules) {
            $day = $this->getScheduleDay();

            return array_merge(
                $rules,
                [
                    'date' => 'bail|required|date|date_format:Y-m-d|exists_school_day:school_days,date|week_day:'.$day,
                ]
            );
        });
    }

    protected function getScheduleDay()
    {
        $input = $this->all();
        $scheduleId = $input['schedule_id'] ?? '';

        if (!$scheduleId) {
            return;
        }

        $schedule = Schedule::where('id', $scheduleId)->first();
        if (!$schedule) {
            return;
        }

        return $schedule->day;
    }
}
