<?php

namespace Emtudo\Units\Responsible\Users\Http\Controllers;

use Emtudo\Domains\Users\Responsibles\Contracts\StudentRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\Responsible\Users\Http\Requests\UpdateUserRequest;
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
        $students = $repository->getAllStudentsByParams($this->params, $this->itemsPerPage, $this->pagination);

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
     * @param string            $id
     * @param UpdateUserRequest $request
     * @param UserRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateUserRequest $request, StudentRepository $repository)
    {
        $student = $repository->findByPublicID($id);

        if (!$student) {
            return $this->respond->notFound('Estudante não encontrado.');
        }

        $repository->update($student, $this->params);

        return $this->respond->ok($student, null);
    }
}
