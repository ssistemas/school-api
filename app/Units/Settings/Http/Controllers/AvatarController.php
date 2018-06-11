<?php

namespace Emtudo\Units\Settings\Http\Controllers;

use Emtudo\Domains\Users\Contracts\UserRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\Settings\Http\Requests\AvatarRequest;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function updateUser($userId, AvatarRequest $request, UserRepository $repository)
    {
        if (!$request->hasFile('avatar')) {
            return $this->respond->error('Você precisa enviar um arquivo');
        }

        if (!$request->file('avatar')->isValid()) {
            return $this->respond->notFound('Arquivo inválido!');
        }

        $user = $repository->findByPublicId($userId);

        if (!$user) {
            return $this->respond->notFound('Usuário não encotnrado');
        }

        $extension = $request->avatar->extension();
        $filename = $user->id.'.'.$extension;

        storage_file_delete('avatars', 'users/'.$user->id.'.'.$user->avatar_exten);

        $path = Storage::disk('avatars')->putFileAs(
            'users',
            $request->file('avatar'),
            $filename
        );

        $user->avatar_exten = $extension;

        $user->save();

        return $this->respond->ok($user, 'Arquivo salvo com sucesso');
    }

    public function update(AvatarRequest $request, UserRepository $repository)
    {
        return $this->updateUser($this->user->publicId(), $request, $repository);
    }
}
