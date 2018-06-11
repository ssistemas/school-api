<?php

namespace Emtudo\Units\Search\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\ResponsibleRepository;
use Emtudo\Domains\Users\Transformers\UserLabelTransformer;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class ResponsibleController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param ResponsibleRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, ResponsibleRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $parents = $repository
            ->select(['id', 'name', 'country_register'])
            ->getAllResponsiblesByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($parents, null, [], [], [], new UserLabelTransformer());
    }

    /**
     * @param string                $id
     * @param ResponsibleRepository $repository
     */
    public function show($id, ResponsibleRepository $repository)
    {
        $parent = $repository->select(['id', 'name', 'country_register'])->findByPublicID($id);

        if (!$parent) {
            return $this->respond->notFound('Responsável não encontrado.');
        }

        return $this->respond->ok($parent, null, [], [], [], new UserLabelTransformer());
    }
}
