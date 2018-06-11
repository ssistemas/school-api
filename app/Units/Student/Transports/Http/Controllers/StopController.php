<?php

namespace Emtudo\Units\Student\Transports\Http\Controllers;

use Emtudo\Domains\Transports\Contracts\StopRepository;
use Emtudo\Support\Http\Controller;
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
}
