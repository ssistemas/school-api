<?php

namespace Emtudo\Domains\Users;

use Emtudo\Domains\Users\Resources\Rules\StudentRules;
use Emtudo\Domains\Users\Transformers\StudentTransformer;

class Student extends User
{
    public $table = 'users';

    /**
     * @var Rules class
     */
    protected static $rulesFrom = StudentRules::class;

    /**
     * @var string user transformer class
     */
    protected $transformerClass = StudentTransformer::class;
}
