<?php

namespace Emtudo\Units\School\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\GradeRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Courses\Http\Requests\Grades\CreateGradeRequest;
use Emtudo\Units\School\Courses\Http\Requests\Grades\CreateGradeSeveralRequest;
use Emtudo\Units\School\Courses\Http\Requests\Grades\UpdateGradeRequest;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
        'quiz_id' => 'id',
        'student_id' => 'id',
        'students' => [
            'student_id' => 'id',
        ],
    ];

    /**
     * @param GradeRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, GradeRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $grades = $repository->getAllGradesByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($grades, null, $this->includes);
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

        return $this->respond->ok($grade, null, $this->includes);
    }

    /**
     * @param CreateGradeRequest $request
     * @param GradeRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateGradeRequest $request, GradeRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $grade = $repository->create($data);

        return $this->respond->ok($grade);
    }

    /**
     * @param CreateGradeSeveralRequest $request
     * @param GradeRepository           $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSeveral(CreateGradeSeveralRequest $request, GradeRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $saved = $repository->createMany($data);

        return $this->respond->ok([], 'Salvo com sucesso!');
    }

    /**
     * @param string             $id
     * @param UpdateGradeRequest $request
     * @param GradeRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateGradeRequest $request, GradeRepository $repository)
    {
        $grade = $repository->findByPublicID($id);

        if (!$grade) {
            return $this->respond->notFound('Nota não encontrada.');
        }

        $data = $this->cleanFields($request->only('value'));

        $repository->update($grade, $data);

        return $this->respond->ok($grade);
    }

    public function destroy($id, GradeRepository $repository)
    {
        $grade = $repository->findByPublicID($id);

        if (!$grade) {
            return $this->respond->notFound('Nota não encontrada.');
        }

        $repository->delete($grade);

        return $this->respond->ok($grade);
    }
}
