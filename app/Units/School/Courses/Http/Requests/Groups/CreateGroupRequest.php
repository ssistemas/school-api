<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Groups;

use Emtudo\Domains\Courses\Group;
use Emtudo\Support\Http\Request;

class CreateGroupRequest extends Request
{
    public function rules()
    {
        return Group::rules()->creating();
    }

    public function attributes()
    {
        return [
            'schedules.*.hour_start' => 'hora',
            'schedules.*.hour_end' => 'hora',
            'schedules.*.monday_skill_id' => 'disciplina',
            'schedules.*.monday_skill_id' => 'disciplina',
            'schedules.*.tuesday_skill_id' => 'disciplina',
            'schedules.*.wednesday_skill_id' => 'disciplina',
            'schedules.*.thursday_skill_id' => 'disciplina',
            'schedules.*.friday_skill_id' => 'disciplina',
        ];
    }
}
