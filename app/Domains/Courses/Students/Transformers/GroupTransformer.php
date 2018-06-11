<?php

namespace Emtudo\Domains\Courses\Students\Transformers;

use Emtudo\Domains\Courses\Group;
use Emtudo\Domains\Courses\Transformers\GroupTransformer as GroupDefaultTransformer;

class GroupTransformer extends GroupDefaultTransformer
{
    public $availableIncludes = [
    ];

    /**
     * @param Group $group
     *
     * @return array
     */
    public function transform(Group $group)
    {
        return [
            'id' => $group->publicId(),
            'label' => $group->course->label.' - '.$group->label.'/'.$group->year,
            'year' => $group->year,
        ];
    }
}
