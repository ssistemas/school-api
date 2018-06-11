<?php

namespace Emtudo\Domains\Courses\Teachers;

use Emtudo\Domains\Courses\Frequency as Model;
use Emtudo\Domains\Courses\Teachers\Transformers\FrequencyTransformer;

class Frequency extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = FrequencyTransformer::class;
}
