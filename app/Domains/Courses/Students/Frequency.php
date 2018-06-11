<?php

namespace Emtudo\Domains\Courses\Students;

use Emtudo\Domains\Courses\Frequency as Model;
use Emtudo\Domains\Courses\Students\Transformers\FrequencyTransformer;

class Frequency extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = FrequencyTransformer::class;
}
