<?php

namespace Emtudo\Domains\Users\Transformers;

use Emtudo\Support\Domain\Repositories\Fractal\Transformer;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class AuthTransformer.
 */
class AuthTransformer extends Transformer
{
    public $availableIncludes = ['user'];

    public function transform(Guard $auth)
    {
        return [
            'token' => $auth->issue(),
        ];
    }

    public function includeUser(Guard $auth)
    {
        $user = $auth->user();

        return $this->item($user, new UserTransformer());
    }
}
