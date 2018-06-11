<?php

namespace Emtudo\Units\School\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\StudentRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Users\Http\Requests\Students\CreateStudentRequest;
use Emtudo\Units\School\Users\Http\Requests\Students\UpdateStudentRequest;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param StudentRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, StudentRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $students = $repository->with(['tenants'])->getAllStudentsByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($students);
    }

    /**
     * @param string            $id
     * @param StudentRepository $repository
     */
    public function show($id, StudentRepository $repository)
    {
        $student = $repository->findByPublicID($id);

        if (!$student) {
            return $this->respond->notFound('Estudante não encontrado.');
        }

        return $this->respond->ok($student, null, ['profiles', 'have_profiles']);
    }

    /**
     * @param CreateStudentRequest $request
     * @param StudentRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateStudentRequest $request, StudentRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $student = $repository->create($data);

        return $this->respond->ok($student);
    }

    /**
     * @param string               $id
     * @param UpdateStudentRequest $request
     * @param StudentRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateStudentRequest $request, StudentRepository $repository)
    {
        $student = $repository->findByPublicID($id);

        if (!$student) {
            return $this->respond->notFound('Estudante não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($student, $data);

        return $this->respond->ok($student);
    }

    public function destroy($id, StudentRepository $repository)
    {
        $student = $repository->findByPublicID($id);

        if (!$student) {
            return $this->respond->notFound('Estudante não encontrado.');
        }

        $deleted = $repository->delete($student);

        if (!$deleted) {
            return $this->respond->error('Falha ao excluir aluno(a)');
        }

        return $this->respond->ok($student);
    }
}
