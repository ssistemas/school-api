<?php

namespace Emtudo\Domains\Courses\Responsibles;

use Emtudo\Domains\Courses\Frequency as Model;
use Emtudo\Domains\Courses\Responsibles\Transformers\FrequencyTransformer;

class Frequency extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = FrequencyTransformer::class;
}
