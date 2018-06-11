<?php

namespace Emtudo\Units\Teacher\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\StudentRepository;
use Emtudo\Support\Http\Controller;
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
}
