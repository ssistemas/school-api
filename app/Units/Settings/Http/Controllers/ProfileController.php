<?php

namespace Emtudo\Units\Settings\Http\Controllers;

use Emtudo\Domains\Users\Contracts\UserRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\Settings\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function show()
    {
        return $this->respond->ok($this->user, null, ['profiles', 'have_profiles']);
    }

    public function update(UpdateProfileRequest $request, UserRepository $repository)
    {
        $user = $this->user;

        $data = $this->cleanFields($request->all());

        $repository->update($user, $data);

        return $this->respond->ok($user, null, ['profiles', 'have_profiles']);
    }
}
