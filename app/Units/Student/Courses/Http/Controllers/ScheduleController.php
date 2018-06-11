<?php

namespace Emtudo\Units\Student\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\ScheduleRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected $cleaningRules = [
    ];

    /**
     * @param ScheduleRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, ScheduleRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $enrollments = $repository->getAllSchedulesByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($enrollments, null, $this->includes);
    }

    /**
     * @param string             $id
     * @param ScheduleRepository $repository
     */
    public function show($id, ScheduleRepository $repository)
    {
        $enrollment = $repository->findByPublicID($id);

        if (!$enrollment) {
            return $this->respond->notFound('Horário não encontrado.');
        }

        return $this->respond->ok($enrollment, null, $this->includes);
    }
}
