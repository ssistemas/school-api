<?php

namespace Emtudo\Units\Search\Calendars\Http\Controllers;

use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @param EventRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, EventRepository $repository)
    {
        $params = $request->all();
        $events = $repository->getAllEventsByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($events);
    }

    /**
     * @param string          $id
     * @param EventRepository $repository
     */
    public function show($id, EventRepository $repository)
    {
        $event = $repository->findByPublicID($id);

        if (!$event) {
            return $this->respond->notFound('Evento não encontrado.');
        }

        // if not found...
        return $this->respond->ok($event);
    }
}
