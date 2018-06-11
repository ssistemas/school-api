<?php

namespace Emtudo\Units\School\Calendars\Http\Controllers;

use Emtudo\Domains\Calendars\Contracts\CalendarRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Calendars\Http\Requests\Calendars\CreateCalendarRequest;
use Emtudo\Units\School\Calendars\Http\Requests\Calendars\UpdateCalendarRequest;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * @param CalendarRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, CalendarRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $calendars = $repository->getAllCalendarsByParams($params, $this->itemsPerPage, true);

        return $this->respond->ok($calendars);
    }

    /**
     * @param string             $id
     * @param CalendarRepository $repository
     */
    public function show($id, CalendarRepository $repository)
    {
        $calendar = $repository->findByPublicID($id);

        if (!$calendar) {
            return $this->respond->notFound('Calendário não encontrado.');
        }

        return $this->respond->ok($calendar);
    }

    /**
     * @param CreateCalendarRequest $request
     * @param CalendarRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCalendarRequest $request, CalendarRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $calendar = $repository->create($data);

        return $this->respond->ok($calendar);
    }

    /**
     * @param string                $id
     * @param UpdateCalendarRequest $request
     * @param CalendarRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateCalendarRequest $request, CalendarRepository $repository)
    {
        $calendar = $repository->findByPublicID($id);

        if (!$calendar) {
            return $this->respond->notFound('Calendário não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($calendar, $data);

        return $this->respond->ok($calendar);
    }

    public function destroy($id, CalendarRepository $repository)
    {
        $calendar = $repository->findByPublicID($id);

        if (!$calendar) {
            return $this->respond->notFound('Calendário não encontrado.');
        }

        $repository->delete($calendar);

        return $this->respond->ok($calendar);
    }
}
