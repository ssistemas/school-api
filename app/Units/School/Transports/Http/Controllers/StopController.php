<?php

namespace Emtudo\Units\School\Transports\Http\Controllers;

use Emtudo\Domains\Transports\Contracts\StopRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Transports\Http\Requests\Stops\CreateStopRequest;
use Emtudo\Units\School\Transports\Http\Requests\Stops\UpdateStopRequest;
use Illuminate\Http\Request;

class StopController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param StopRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, StopRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $stops = $repository->getAllStopsByParams($params, $this->itemsPerPage, true);

        return $this->respond->ok($stops);
    }

    /**
     * @param string         $id
     * @param StopRepository $repository
     */
    public function show($id, StopRepository $repository)
    {
        $stop = $repository->findByPublicID($id);

        if (!$stop) {
            return $this->respond->notFound('Parada não encontrada.');
        }

        // if not found...
        return $this->respond->ok($stop);
    }

    /**
     * @param CreateStopRequest $request
     * @param StopRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateStopRequest $request, StopRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $stop = $repository->create($data);

        return $this->respond->ok($stop);
    }

    /**
     * @param string            $id
     * @param UpdateStopRequest $request
     * @param StopRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateStopRequest $request, StopRepository $repository)
    {
        $stop = $repository->findByPublicID($id);

        if (!$stop) {
            return $this->respond->notFound('Parada não encontrada.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($stop, $data);

        return $this->respond->ok($stop);
    }

    public function destroy($id, StopRepository $repository)
    {
        $stop = $repository->findByPublicID($id);

        if (!$stop) {
            return $this->respond->notFound('Parada não encontrada.');
        }

        $repository->delete($stop);

        return $this->respond->ok($stop);
    }
}
