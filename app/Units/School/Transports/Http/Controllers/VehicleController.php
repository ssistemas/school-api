<?php

namespace Emtudo\Units\School\Transports\Http\Controllers;

use Emtudo\Domains\Transports\Contracts\VehicleRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Transports\Http\Requests\Vehicles\CreateVehicleRequest;
use Emtudo\Units\School\Transports\Http\Requests\Vehicles\UpdateVehicleRequest;
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

    /**
     * @param CreateVehicleRequest $request
     * @param VehicleRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateVehicleRequest $request, VehicleRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $vehicle = $repository->create($data);

        return $this->respond->ok($vehicle);
    }

    /**
     * @param string               $id
     * @param UpdateVehicleRequest $request
     * @param VehicleRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateVehicleRequest $request, VehicleRepository $repository)
    {
        $vehicle = $repository->findByPublicID($id);

        if (!$vehicle) {
            return $this->respond->notFound('Veículo não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($vehicle, $data);

        return $this->respond->ok($vehicle);
    }

    public function destroy($id, VehicleRepository $repository)
    {
        $vehicle = $repository->findByPublicID($id);

        if (!$vehicle) {
            return $this->respond->notFound('Veículo não encontrado.');
        }

        $repository->delete($vehicle);

        return $this->respond->ok($vehicle);
    }
}
