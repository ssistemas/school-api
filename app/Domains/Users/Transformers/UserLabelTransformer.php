<?php

namespace Emtudo\Domains\Users\Transformers;

use Emtudo\Domains\Users\User;

class UserLabelTransformer extends UserTransformer
{
    public function transform(User $user)
    {
        $label = $user->name;
        if ($user->country_register) {
            $label = $label . ' - ' . $user->country_register;
        }

        return [
            'id' => $user->publicId(),
            'label' => $label,
        ];
    }
}
