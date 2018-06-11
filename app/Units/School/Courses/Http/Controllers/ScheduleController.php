<?php

namespace Emtudo\Units\School\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\ScheduleRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Courses\Http\Requests\Schedules\CreateCourseRequest;
use Emtudo\Units\School\Courses\Http\Requests\Schedules\UpdateCourseRequest;
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

    /**
     * @param CreateCourseRequest $request
     * @param ScheduleRepository  $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCourseRequest $request, ScheduleRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $enrollment = $repository->create($data);

        return $this->respond->ok($enrollment);
    }

    /**
     * @param string              $id
     * @param UpdateCourseRequest $request
     * @param ScheduleRepository  $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateCourseRequest $request, ScheduleRepository $repository)
    {
        $enrollment = $repository->findByPublicID($id);

        if (!$enrollment) {
            return $this->respond->notFound('Horário não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($enrollment, $data);

        return $this->respond->ok($enrollment);
    }

    public function destroy($id, ScheduleRepository $repository)
    {
        $enrollment = $repository->findByPublicID($id);

        if (!$enrollment) {
            return $this->respond->notFound('Horário não encontrado.');
        }

        $repository->delete($enrollment);

        return $this->respond->ok($enrollment);
    }
}
