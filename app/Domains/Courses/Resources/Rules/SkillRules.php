<?php

namespace Emtudo\Domains\Courses\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class SkillRules extends Rules
{
    public function defaultRules()
    {
        return [
            'user_id' => 'required|exists_public_id_by_tenant:users,id',
            'subject_id' => 'required|exists_public_id_by_tenant:subjects,id',
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
