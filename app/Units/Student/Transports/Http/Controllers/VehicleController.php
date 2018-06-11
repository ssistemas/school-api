<?php

namespace Emtudo\Units\Student\Transports\Http\Controllers;

use Emtudo\Domains\Transports\Contracts\VehicleRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
        'routes' => [
            'route_id' => 'id',
        ],
    ];

    /**
     * @param VehicleRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, VehicleRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $vehicles = $repository->getAllVehiclesByParams($params, $this->itemsPerPage, true);

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
        return $this->respond->ok($vehicle, null, ['routes']);
    }
}
