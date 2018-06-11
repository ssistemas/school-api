<?php

namespace Emtudo\Domains\Users\Transformers;

use Emtudo\Domains\Users\User;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

/**
 * Class DirectorTransformer.
 */
class DirectorTransformer extends Transformer
{
    public function transform(User $user)
    {
        return [
            'id' => $user->publicId(),
            'name' => $user->name,
        ];
    }
}
