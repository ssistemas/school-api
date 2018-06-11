<?php

namespace Emtudo\Domains\Courses\Responsibles;

use Emtudo\Domains\Courses\Group as Model;
use Emtudo\Domains\Courses\Responsibles\Transformers\GroupTransformer;

class Group extends Model
{
    /**
     * @var string
     */
    protected $transformerClass = GroupTransformer::class;
}
