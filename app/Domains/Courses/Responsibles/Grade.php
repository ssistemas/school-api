<?php

namespace Emtudo\Domains\Courses\Responsibles;

use Emtudo\Domains\Courses\Grade as Model;
use Emtudo\Domains\Courses\Responsibles\Transformers\GradeTransformer;

class Grade extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = GradeTransformer::class;
}
