<?php

namespace Emtudo\Domains\Users;

use Emtudo\Domains\Users\Resources\Rules\ManagerRules;
use Emtudo\Domains\Users\Transformers\ManagerTransformer;

class Manager extends User
{
    public $table = 'users';

    /**
     * @var Rules class
     */
    protected static $rulesFrom = ManagerRules::class;

    /**
     * @var string user transformer class
     */
    protected $transformerClass = ManagerTransformer::class;
}
