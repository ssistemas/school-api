<?php

namespace Emtudo\Units\Search\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\ScheduleRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * @param ScheduleRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, ScheduleRepository $repository)
    {
        $params = $request->all();
        $scheudles = $repository->getAllSchedulesByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($scheudles);
    }

    /**
     * @param string             $id
     * @param ScheduleRepository $repository
     */
    public function show($id, ScheduleRepository $repository)
    {
        $scheudle = $repository->findByPublicID($id);

        if (!$scheudle) {
            return $this->respond->notFound('Horário não encontrado.');
        }

        return $this->respond->ok($scheudle);
    }
}
