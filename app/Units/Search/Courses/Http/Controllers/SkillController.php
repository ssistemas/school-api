<?php

namespace Emtudo\Units\Search\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\SkillRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * @param SkillRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, SkillRepository $repository)
    {
        $params = $request->all();
        $skills = $repository->getAllSkillsByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($skills);
    }

    /**
     * @param string          $id
     * @param SkillRepository $repository
     */
    public function show($id, SkillRepository $repository)
    {
        $skill = $repository->findByPublicID($id);

        if (!$skill) {
            return $this->respond->notFound('Habilidade não encontrada.');
        }

        return $this->respond->ok($skill);
    }
}
