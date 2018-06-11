<?php

namespace Emtudo\Domains\Courses\Students;

use Emtudo\Domains\Courses\Grade as Model;
use Emtudo\Domains\Courses\Students\Transformers\GradeTransformer;

class Grade extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = GradeTransformer::class;
}
