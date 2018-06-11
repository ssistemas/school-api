<?php

namespace Emtudo\Domains\Users\Transformers;

use Carbon\Carbon;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class UserBirthdayTransformer extends Transformer
{
    public $availableIncludes = [];

    public function transform(User $user)
    {
        $age = $user->birthdate->age;

        $date = Carbon::parse($user->birthdate->format(now()->format('Y').'-m-d'));
        if ($date->isFuture()) {
            ++$age;
        }

        return [
            'id' => $user->publicId(),
            'avatar' => $user->getAvatarUrl(),
            'birthdate' => $user->getValue('birthdate'),
            'name' => $user->name,
            'age' => $age,
        ];
    }
}
