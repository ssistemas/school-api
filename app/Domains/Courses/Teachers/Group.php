<?php

namespace Emtudo\Domains\Courses\Teachers;

use Emtudo\Domains\Courses\Group as Model;
use Emtudo\Domains\Courses\Teachers\Transformers\GroupTransformer;

class Group extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = GroupTransformer::class;
}
