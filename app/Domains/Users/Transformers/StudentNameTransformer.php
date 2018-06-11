<?php

namespace Emtudo\Domains\Users\Transformers;

use Emtudo\Domains\Users\User;

class StudentNameTransformer extends UserTransformer
{
    public function transform(User $user)
    {
        $label = $user->name;
        if ($user->country_register) {
            $label = $label.' - '.$user->country_register;
        }

        return [
            'id' => $user->publicId(),
            'name' => $label,
            'avatar' => $user->getAvatarUrl(),
        ];
    }
}
