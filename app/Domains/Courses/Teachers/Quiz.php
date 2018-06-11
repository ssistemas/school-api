<?php

namespace Emtudo\Domains\Courses\Teachers;

use Emtudo\Domains\Courses\Quiz as Model;
use Emtudo\Domains\Courses\Teachers\Transformers\QuizTransformer;

class Quiz extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = QuizTransformer::class;
}
