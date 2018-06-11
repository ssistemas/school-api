<?php

namespace Emtudo\Units\Search\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\TeacherRepository;
use Emtudo\Domains\Users\Transformers\UserLabelTransformer;
use Emtudo\Support\Http\Controller;
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
        $teachers = $repository
            ->select(['id', 'name', 'country_register'])
            ->getAllTeachersByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($teachers, null, [], [], [], new UserLabelTransformer());
    }

    /**
     * @param string            $id
     * @param TeacherRepository $repository
     */
    public function show($id, TeacherRepository $repository)
    {
        $teacher = $repository->select(['id', 'name', 'country_register'])->findByPublicID($id);

        if (!$teacher) {
            return $this->respond->notFound('Professor(a) não encontrado.');
        }

        return $this->respond->ok($teacher, null, [], [], [], new UserLabelTransformer());
    }
}
