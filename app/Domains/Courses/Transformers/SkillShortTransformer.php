<?php

namespace Emtudo\Domains\Courses\Transformers;

use Emtudo\Domains\Courses\Skill;

class SkillShortTransformer extends SkillTransformer
{
    /**
     * @param Skill $skill
     *
     * @return array
     */
    public function transform(Skill $skill)
    {
        return [
            'id' => $skill->publicId(),
            'label' => $skill->getShortLabel(),
        ];
    }
}
