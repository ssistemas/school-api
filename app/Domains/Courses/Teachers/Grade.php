<?php

namespace Emtudo\Domains\Courses\Teachers;

use Emtudo\Domains\Courses\Grade as Model;
use Emtudo\Domains\Courses\Teachers\Transformers\GradeTransformer;

class Grade extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = GradeTransformer::class;
}
