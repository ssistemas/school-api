<?php

namespace Emtudo\Units\Search\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\UserRepository;
use Emtudo\Domains\Users\Transformers\UserLabelTransformer;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param UserRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, UserRepository $repository)
    {
        $users = $repository
            ->select(['id', 'name', 'country_register'])
            ->getAllUsersByParams($this->params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($users, null, $this->includes, [], [], new UserLabelTransformer());
    }

    /**
     * @param string         $id
     * @param UserRepository $repository
     */
    public function show($id, UserRepository $repository)
    {
        $user = $repository->select(['id', 'name', 'country_register'])->findByPublicID($id);

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado.');
        }

        return $this->respond->ok($user, null, $this->includes, [], [], new UserLabelTransformer());
    }
}
