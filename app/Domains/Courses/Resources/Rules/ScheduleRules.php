<?php

namespace Emtudo\Domains\Courses\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class ScheduleRules extends Rules
{
    public function defaultRules()
    {
        return [
            'group_id' => 'required|exists_public_id_by_tenant:groups,id',
            'hour_start' => 'required|time',
            'hour_end' => 'required|time',
            'skill_id' => 'required|exists_public_id_by_tenant:skills,id',
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
