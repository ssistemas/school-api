<?php

namespace Emtudo\Units\Search\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\ManagerRepository;
use Emtudo\Domains\Users\Transformers\UserLabelTransformer;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param ManagerRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, ManagerRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $managers = $repository
            ->select(['id', 'name', 'country_register'])
            ->getAllManagersByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($managers, null, [], [], [], new UserLabelTransformer());
    }

    /**
     * @param string            $id
     * @param ManagerRepository $repository
     */
    public function show($id, ManagerRepository $repository)
    {
        $manager = $repository->select(['id', 'name', 'country_register'])->findByPublicID($id);

        if (!$manager) {
            return $this->respond->notFound('Usuário não encontrado.');
        }

        return $this->respond->ok($manager, null, [], [], [], new UserLabelTransformer());
    }
}
