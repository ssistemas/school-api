<?php

namespace Emtudo\Units\Search\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\GroupRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * @param GroupRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, GroupRepository $repository)
    {
        $params = $request->all();
        $groups = $repository->getAllGroupsByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($groups, null, $this->includes);
    }

    /**
     * @param string          $id
     * @param GroupRepository $repository
     */
    public function show($id, GroupRepository $repository)
    {
        $group = $repository->findByPublicID($id);

        if (!$group) {
            return $this->respond->notFound('Turma não encontrada.');
        }

        return $this->respond->ok($group);
    }
}
