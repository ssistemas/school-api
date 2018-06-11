<?php

namespace Emtudo\Domains\Users;

use Emtudo\Domains\Users\Resources\Rules\TeacherRules;
use Emtudo\Domains\Users\Transformers\TeacherTransformer;

class Teacher extends User
{
    public $table = 'users';

    /**
     * @var Rules class
     */
    protected static $rulesFrom = TeacherRules::class;

    /**
     * @var string user transformer class
     */
    protected $transformerClass = TeacherTransformer::class;
}
