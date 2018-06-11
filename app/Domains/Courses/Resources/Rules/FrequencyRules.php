<?php

namespace Emtudo\Domains\Courses\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class FrequencyRules extends Rules
{
    public function defaultRules()
    {
        return [
            'schedule_id' => 'required|exists:schedules,id',
            // 'school_day_id' => 'required|exists_public_id:school_days,id',
            'student_id' => 'required|exists_public_id:users,id',
            'present' => 'required|boolean',
            'justified_absence' => 'nullable|sometimes|boolean',
        ];
    }

    public function creating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }

    public function updating($callback = null)
    {
        return $this->rules([
            'id' => 'required|exists:frequencies,id',
            'present' => 'required|boolean',
            'justified_absence' => 'nullable|sometimes|boolean',
        ], $callback);
    }

    public function several($callback = null)
    {
        return $this->rules([
            'schedule_id' => 'required|exists:schedules,id',
            //'date' => 'bail|required|date|date_format:Y-m-d|exists_school_day:school_days,date',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists_public_id:users,id',
            'students.*.present' => 'required|boolean',
            'students.*.justified_absence' => 'nullable|sometimes|boolean',
        ], $callback);
    }
}
