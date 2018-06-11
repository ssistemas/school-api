<?php

namespace Emtudo\Domains\Courses\Transformers;

use Emtudo\Domains\Courses\Schedule;

class ScheduleShortTransformer extends ScheduleTransformer
{
    public $availableIncludes = [
        'skill',
    ];

    /**
     * @param Schedule $schedule
     *
     * @return array
     */
    public function transform(Schedule $schedule)
    {
        return [
        ];
    }

    public function includeSkill(Schedule $schedule)
    {
        $skill = $schedule->skill;
        if (!$skill) {
            return;
        }

        return $this->item($skill, new SkillShortTransformer());
    }
}
