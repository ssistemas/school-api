<?php

namespace Emtudo\Domains\Courses\Students;

use Emtudo\Domains\Courses\Group as Model;
use Emtudo\Domains\Courses\Students\Transformers\GroupTransformer;

class Group extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = GroupTransformer::class;
}
