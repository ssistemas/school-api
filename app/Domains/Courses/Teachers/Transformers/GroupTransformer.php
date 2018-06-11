<?php

namespace Emtudo\Domains\Courses\Teachers\Transformers;

use Emtudo\Domains\Courses\Group;
use Emtudo\Domains\Courses\Transformers\GroupTransformer as Transformer;
use Emtudo\Domains\Courses\Transformers\QuizTransformer;

class GroupTransformer extends Transformer
{
    public $availableIncludes = [
        'course',
        'my_schedules',
        'my_skills',
        'students',
        'quizzes',
    ];

    public function includeQuizzes(Group $group)
    {
        $quizzes = $group->getQuizzes(auth()->user()->id);

        if (!$quizzes) {
            return;
        }

        return $this->collection($quizzes, new QuizTransformer());
    }

    public function includeMySchedules(Group $group)
    {
        $user = auth()->user();

        return $this->includeForceMySchedules($group, $user->id);
    }

    public function includeMySkills(Group $group)
    {
        $user = auth()->user();

        return $this->includeForceMySkills($group, $user->id);
    }
}
