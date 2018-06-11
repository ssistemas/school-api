<?php

namespace Emtudo\Domains\Courses\Students\Transformers;

use Emtudo\Domains\Courses\Schedule;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class ScheduleTransformer extends Transformer
{
    public $availableIncludes = [
        'group',
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
            'id' => $schedule->getValue('id'),
            'label' => $schedule->getLabel(),
            'group_id' => encode_id($schedule->group_id),
            'skill_id' => encode_id($schedule->skill_id),

            'day' => $schedule->day,
            'index' => $schedule->index,

            'hour_start' => $schedule->hour_start,
            'hour_end' => $schedule->hour_end,
        ];
    }

    public function includeGroup(Schedule $schedule)
    {
        $group = $schedule->group;
        if (!$group) {
            return;
        }

        return $this->item($group, new GroupTransformer());
    }

    public function includeSkill(Schedule $schedule)
    {
        $skill = $schedule->skill;
        if (!$skill) {
            return;
        }

        return $this->item($skill, new SkillTransformer());
    }
}
