<?php

namespace Emtudo\Domains\Courses\Teachers;

use Emtudo\Domains\Courses\Subject as Model;
use Emtudo\Domains\Courses\Teachers\Transformers\SubjectTransformer;

class Subject extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = SubjectTransformer::class;
}
