<?php

namespace Emtudo\Units\Search\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\GradeRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * @param GradeRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, GradeRepository $repository)
    {
        $params = $request->all();
        $grades = $repository->getAllGradesByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($grades);
    }

    /**
     * @param string          $id
     * @param GradeRepository $repository
     */
    public function show($id, GradeRepository $repository)
    {
        $grade = $repository->findByPublicID($id);

        if (!$grade) {
            return $this->respond->notFound('Nota não encontrada.');
        }

        return $this->respond->ok($grade);
    }
}
