<?php

namespace Emtudo\Domains\Courses;

use Emtudo\Domains\Pivot;

class SkillUserPivot extends Pivot
{
    protected $fillable = [
        'teacher_id',
        'subject_id',
    ];
}
