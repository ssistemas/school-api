<?php

namespace Emtudo\Units\School\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\TeacherRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Users\Http\Requests\Teachers\CreateTeacherRequest;
use Emtudo\Units\School\Users\Http\Requests\Teachers\UpdateTeacherRequest;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param TeacherRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, TeacherRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $teachers = $repository->getAllTeachersByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($teachers);
    }

    /**
     * @param string            $id
     * @param TeacherRepository $repository
     */
    public function show($id, TeacherRepository $repository)
    {
        $teacher = $repository->findByPublicID($id);

        if (!$teacher) {
            return $this->respond->notFound('Docente não encontrado.');
        }

        return $this->respond->ok($teacher, null, ['profiles', 'have_profiles']);
    }

    /**
     * @param CreateTeacherRequest $request
     * @param TeacherRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTeacherRequest $request, TeacherRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $teacher = $repository->create($data);

        return $this->respond->ok($teacher);
    }

    /**
     * @param string               $id
     * @param UpdateTeacherRequest $request
     * @param TeacherRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateTeacherRequest $request, TeacherRepository $repository)
    {
        $teacher = $repository->findByPublicID($id);

        if (!$teacher) {
            return $this->respond->notFound('Docente não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($teacher, $data);

        return $this->respond->ok($teacher);
    }

    public function destroy($id, TeacherRepository $repository)
    {
        $teacher = $repository->findByPublicID($id);

        if (!$teacher) {
            return $this->respond->notFound('Docente não encontrado.');
        }

        $deleted = $repository->delete($teacher);

        if (!$deleted) {
            return $this->respond->error('Falha ao excluir docente');
        }

        return $this->respond->ok($teacher);
    }
}
