<?php

namespace Emtudo\Units\Search\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\StudentRepository;
use Emtudo\Domains\Users\Transformers\UserLabelTransformer;
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
        $students = $repository
            ->select(['id', 'name', 'country_register'])
            ->getAllStudentsByParams($this->params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($students, null, $this->includes, [], [], new UserLabelTransformer());
    }

    /**
     * @param string            $id
     * @param StudentRepository $repository
     */
    public function show($id, StudentRepository $repository)
    {
        $student = $repository->select(['id', 'name', 'country_register'])->findByPublicID($id);

        if (!$student) {
            return $this->respond->notFound('Aluno(a) não encontrado.');
        }

        return $this->respond->ok($student, null, $this->includes, [], [], new UserLabelTransformer());
    }
}
