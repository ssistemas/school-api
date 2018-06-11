<?php

namespace Emtudo\Units\School\Calendars\Http\Controllers;

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
        $params = $this->cleanFields($request->all());
        $events = $repository->getAllEventsByParams($params, $this->itemsPerPage, true);

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

        return $this->respond->ok($event);
    }

    /**
     * @param CreateEventRequest $request
     * @param EventRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateEventRequest $request, EventRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $event = $repository->create($data);

        return $this->respond->ok($event);
    }

    /**
     * @param string             $id
     * @param UpdateEventRequest $request
     * @param EventRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateEventRequest $request, EventRepository $repository)
    {
        $event = $repository->findByPublicID($id);

        if (!$event) {
            return $this->respond->notFound('Evento não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($event, $data);

        return $this->respond->ok($event);
    }

    public function destroy($id, EventRepository $repository)
    {
        $event = $repository->findByPublicID($id);

        if (!$event) {
            return $this->respond->notFound('Evento não encontrado.');
        }

        $repository->delete($event);

        return $this->respond->ok($event);
    }
}
