<?php

namespace Emtudo\Units\School\Calendars\Http\Controllers;

use Emtudo\Domains\Calendars\Contracts\SchoolDayRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Calendars\Http\Requests\SchoolDays\CreateSchoolDayRequest;
use Emtudo\Units\School\Calendars\Http\Requests\SchoolDays\ToggleSchoolDayRequest;
use Emtudo\Units\School\Calendars\Http\Requests\SchoolDays\UpdateSchoolDayRequest;
use Illuminate\Http\Request;

class SchoolDayController extends Controller
{
    /**
     * @param SchoolDayRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, SchoolDayRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $schoolDays = $repository->getAllSchoolDaysByParams($params, $this->itemsPerPage, true);

        return $this->respond->ok($schoolDays);
    }

    /**
     * @param string              $id
     * @param SchoolDayRepository $repository
     */
    public function show($id, SchoolDayRepository $repository)
    {
        $schoolDay = $repository->findByPublicID($id);

        if (!$schoolDay) {
            return $this->respond->notFound('Dia letivo não encontrado.');
        }

        return $this->respond->ok($schoolDay);
    }

    public function toggle(ToggleSchoolDayRequest $request, SchoolDayRepository $repository)
    {
        $schoolDay = $repository->getFromDate($request->get('date'));

        if (!$schoolDay) {
            return $this->respond->notFound('Dia letivo não encontrado.');
        }

        $repository->toggle($schoolDay);

        return $this->respond->ok($schoolDay);
    }

    public function holidaysFromYear(int $year, SchoolDayRepository $repository)
    {
        $schoolDays = $repository->getHolidaysFromYear($year);

        return $this->respond->ok($schoolDays);
    }

    public function holidaysInCurrentYear(SchoolDayRepository $repository)
    {
        $schoolDays = $repository->getHolidaysInCurrentYear();

        return $this->respond->ok($schoolDays);
    }

    /**
     * @param CreateSchoolDayRequest $request
     * @param SchoolDayRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSchoolDayRequest $request, SchoolDayRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $schoolDay = $repository->create($data);

        return $this->respond->ok($schoolDay);
    }

    /**
     * @param string                 $id
     * @param UpdateSchoolDayRequest $request
     * @param SchoolDayRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateSchoolDayRequest $request, SchoolDayRepository $repository)
    {
        $schoolDay = $repository->findByPublicID($id);

        if (!$schoolDay) {
            return $this->respond->notFound('Dia letivo não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($schoolDay, $data);

        return $this->respond->ok($schoolDay);
    }

    public function destroy($id, SchoolDayRepository $repository)
    {
        $schoolDay = $repository->findByPublicID($id);

        if (!$schoolDay) {
            return $this->respond->notFound('Dia letivo não encontrado.');
        }

        $repository->delete($schoolDay);

        return $this->respond->ok($schoolDay);
    }
}
