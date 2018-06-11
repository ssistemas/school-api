<?php

namespace Emtudo\Domains\Courses\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class GroupRules extends Rules
{
    public function defaultRules()
    {
        return [
            'course_id' => 'required|exists_public_id_by_tenant:courses,id',
            'label' => 'required|string|max:255',
            'year' => 'required|integer|min:2018|max:2099',
            'max_students' => 'required|integer|min:1|max:9999',
            'schedules' => 'required|array',
            'schedules.*.hour_start' => 'required|time',
            'schedules.*.hour_end' => 'required|time',
            'schedules.*.monday_skill_id' => 'required|exists_public_id_by_tenant:skills,id',
            'schedules.*.tuesday_skill_id' => 'required|exists_public_id_by_tenant:skills,id',
            'schedules.*.wednesday_skill_id' => 'required|exists_public_id_by_tenant:skills,id',
            'schedules.*.thursday_skill_id' => 'required|exists_public_id_by_tenant:skills,id',
            'schedules.*.friday_skill_id' => 'required|exists_public_id_by_tenant:skills,id',
            'students' => 'sometimes|array',
            'students.*.student_id' => 'required|exists_public_id:users,id',
            'students.*.route_id' => 'nullable|sometimes|exists_public_id:routes,id',
            // 'pass_score' => 'nullable|sometimes|integer|min:1|max:100',
            // 'period' => 'required|integer|min:1|max:12',
        ];
    }

    public function creating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }

    public function updating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }
}
