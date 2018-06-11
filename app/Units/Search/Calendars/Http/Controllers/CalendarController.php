<?php

namespace Emtudo\Units\Search\Calendars\Http\Controllers;

use Emtudo\Domains\Calendars\Contracts\CalendarRepository;
use Emtudo\Support\Http\Controller;
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
        $params = $request->all();
        $calendars = $repository->getAllCalendarsByParams($params, $this->itemsPerPage, $this->pagination);

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

        // if not found...
        return $this->respond->ok($calendar);
    }
}
