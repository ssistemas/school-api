<?php

namespace Emtudo\Units\Search\Transports\Http\Controllers;

use Emtudo\Domains\Transports\Contracts\StopRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class StopController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param StopRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, StopRepository $repository)
    {
        $data = [];
        if ($request->has('search')) {
            $data = $request->get('search');
        }
        if (!is_array($data)) {
            $data = [$data];
        }
        $stops = $repository->getAllStopsByParams($data, $this->itemsPerPage, $this->pagination);

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
