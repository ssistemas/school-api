<?php

namespace Emtudo\Units\Teacher\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\TeacherRepository;
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
}
