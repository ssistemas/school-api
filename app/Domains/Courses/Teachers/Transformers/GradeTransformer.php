<?php

namespace Emtudo\Domains\Courses\Teachers\Transformers;

use Emtudo\Domains\Courses\Transformers\GradeTransformer as Transformer;

class GradeTransformer extends Transformer
{
    public $availableIncludes = [
        'quiz',
        'student',
    ];
}
