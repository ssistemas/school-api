<?php

namespace Emtudo\Units\School\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\SkillRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Courses\Http\Requests\Skills\CreateCourseRequest;
use Emtudo\Units\School\Courses\Http\Requests\Skills\UpdateCourseRequest;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param SkillRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, SkillRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $skills = $repository->getAllSkillsByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($skills, null, $this->includes);
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

        return $this->respond->ok($skill, null, $this->includes);
    }

    /**
     * @param CreateCourseRequest $request
     * @param SkillRepository     $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCourseRequest $request, SkillRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $skill = $repository->create($data);

        return $this->respond->ok($skill);
    }

    /**
     * @param string              $id
     * @param UpdateCourseRequest $request
     * @param SkillRepository     $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateCourseRequest $request, SkillRepository $repository)
    {
        $skill = $repository->findByPublicID($id);

        if (!$skill) {
            return $this->respond->notFound('Habilidade não encontrada.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($skill, $data);

        return $this->respond->ok($skill);
    }

    public function destroy($id, SkillRepository $repository)
    {
        $skill = $repository->findByPublicID($id);

        if (!$skill) {
            return $this->respond->notFound('Habilidade não encontrada.');
        }

        $repository->delete($skill);

        return $this->respond->ok($skill);
    }
}
