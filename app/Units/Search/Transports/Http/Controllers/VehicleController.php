<?php

namespace Emtudo\Units\Search\Transports\Http\Controllers;

use Emtudo\Domains\Transports\Contracts\VehicleRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param VehicleRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, VehicleRepository $repository)
    {
        $data = [];
        if ($request->has('search')) {
            $data = $request->get('search');
        }
        if (!is_array($data)) {
            $data = [$data];
        }
        $vehicles = $repository->getAllVehiclesByParams($data, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($vehicles);
    }

    /**
     * @param string            $id
     * @param VehicleRepository $repository
     */
    public function show($id, VehicleRepository $repository)
    {
        $vehicle = $repository->findByPublicID($id);

        if (!$vehicle) {
            return $this->respond->notFound('Veículo não encontrado.');
        }

        // if not found...
        return $this->respond->ok($vehicle);
    }
}
