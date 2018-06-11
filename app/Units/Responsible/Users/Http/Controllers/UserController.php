<?php

namespace Emtudo\Units\Responsible\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\UserRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\Responsible\Users\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param string         $id
     * @param UserRepository $repository
     */
    public function show($id, UserRepository $repository)
    {
        $user = $repository->with(['tenants'])->findByPublicID($id);

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado.');
        }

        return $this->respond->ok($user, null, ['profiles', 'have_profiles']);
    }

    /**
     * @param UserRepository $repository
     */
    public function showMe(UserRepository $repository)
    {
        return $this->show($this->user->publicId(), $repository);
    }

    /**
     * @param string            $id
     * @param UpdateUserRequest $request
     * @param UserRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateUserRequest $request, UserRepository $repository)
    {
        $user = $repository->findByPublicID($id);

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado.');
        }

        if ($user->id !== $this->user->id) {
            $user->is_admin = $request->get('is_admin', false);
        }
        $data = $this->cleanFields($request->all());

        $repository->update($user, $data);
        $profiles = $request->get('have_profiles', []);
        $repository->attachProfiles($user, $profiles);

        return $this->respond->ok($user, null);
    }

    /**
     * @param UpdateUserRequest $request
     * @param UserRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMe(UpdateUserRequest $request, UserRepository $repository)
    {
        return $this->update($this->user->publicId(), $request, $repository);
    }

    public function destroyDocument($userId, $kind, UserRepository $repository)
    {
        $user = $repository->findByPublicID($userId);

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado.');
        }

        $documents = array_merge(
            $user->documents ?? [],
            [$kind => null]
        );
        $user->deleteDocumentByKind($kind);
        $user->documents = $documents;
        $user->save();

        return $this->respond->ok($user);
    }

    public function getDocumetByKind($userId, $kind, UserRepository $repository)
    {
        $user = $repository->findByPublicID($userId);

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado.');
        }

        $document = $user->getBase64DocumentByKind($kind);

        return $this->respond->ok($document);
    }
}
