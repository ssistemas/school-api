<?php

namespace Emtudo\Support\Response\Json\Traits;

use Emtudo\Support\Response\Json\Contracts\Factory;

trait JsonResponseTrait
{
    /**
     * @return Factory
     */
    protected function response()
    {
        return app(Factory::class);
    }
}
