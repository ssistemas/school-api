<?php

namespace Emtudo\Units\School\Calendars\Http\Controllers;

use Emtudo\Domains\Calendars\Contracts\TwoMonthRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Calendars\Http\Requests\TwoMonths\CreateTwoMonthRequest;
use Emtudo\Units\School\Calendars\Http\Requests\TwoMonths\UpdateTwoMonthRequest;
use Illuminate\Http\Request;

class TwoMonthController extends Controller
{
    /**
     * @param TwoMonthRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, TwoMonthRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $schoolDays = $repository->getAllTwoMonthsByParams($params, $this->itemsPerPage, true);

        return $this->respond->ok($schoolDays);
    }

    /**
     * @param int                $id
     * @param TwoMonthRepository $repository
     */
    public function show(int $id, TwoMonthRepository $repository)
    {
        $schoolDay = $repository->findByID($id);

        if (!$schoolDay) {
            return $this->respond->notFound('Bimestre não encontrado.');
        }

        return $this->respond->ok($schoolDay);
    }

    /**
     * @param CreateTwoMonthRequest $request
     * @param TwoMonthRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTwoMonthRequest $request, TwoMonthRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $schoolDay = $repository->create($data);

        return $this->respond->ok($schoolDay);
    }

    /**
     * @param int                   $id
     * @param UpdateTwoMonthRequest $request
     * @param TwoMonthRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, UpdateTwoMonthRequest $request, TwoMonthRepository $repository)
    {
        $schoolDay = $repository->findByID($id);

        if (!$schoolDay) {
            return $this->respond->notFound('Bimestre não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($schoolDay, $data);

        return $this->respond->ok($schoolDay);
    }
}
