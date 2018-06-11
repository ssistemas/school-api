<?php

namespace Emtudo\Domains\Courses\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class GradeRules extends Rules
{
    public function defaultRules()
    {
        return [
            'quiz_id' => 'required|exists_public_id_by_tenant:quizzes,id',
            'student_id' => 'required|exists_public_id:users,id',
            'value' => 'required|integer|min:0|max:100',
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

    public function several($callback = null)
    {
        return $this->rules([
            'quiz_id' => 'required|exists_public_id_by_tenant:quizzes,id',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists_public_id:users,id',
            'students.*.grade' => 'required|integer|min:0|max:100',
        ], $callback);
    }
}
