<?php

namespace Emtudo\Domains\Users;

use Emtudo\Domains\Users\Resources\Rules\ResponsibleRules;
use Emtudo\Domains\Users\Transformers\ResponsibleTransformer;

class Responsible extends User
{
    public $table = 'users';

    /**
     * @var Rules class
     */
    protected static $rulesFrom = ResponsibleRules::class;

    /**
     * @var string user transformer class
     */
    protected $transformerClass = ResponsibleTransformer::class;
}
