<?php

namespace Emtudo\Units\School\Transports\Http\Controllers;

use Emtudo\Domains\Transports\Contracts\RouteRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Transports\Http\Requests\Routes\CreateRouteRequest;
use Emtudo\Units\School\Transports\Http\Requests\Routes\UpdateRouteRequest;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
        'stops' => [
            'stop_id' => 'id',
        ],
    ];

    /**
     * @param RouteRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, RouteRepository $repository)
    {
        $params = $this->cleanFields($request->all());

        $routes = $repository->getAllRoutesByParams($params, $this->itemsPerPage, true);

        return $this->respond->ok($routes);
    }

    /**
     * @param string          $id
     * @param RouteRepository $repository
     */
    public function show($id, RouteRepository $repository)
    {
        $route = $repository->findByPublicID($id);

        if (!$route) {
            return $this->respond->notFound('Rota não encontrada.');
        }

        // if not found...
        return $this->respond->ok($route, null, ['stops']);
    }

    /**
     * @param CreateRouteRequest $request
     * @param RouteRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRouteRequest $request, RouteRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $route = $repository->create($data);

        return $this->respond->ok($route);
    }

    /**
     * @param string             $id
     * @param UpdateRouteRequest $request
     * @param RouteRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateRouteRequest $request, RouteRepository $repository)
    {
        $route = $repository->findByPublicID($id);

        if (!$route) {
            return $this->respond->notFound('Rota não encontrada.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($route, $data);

        return $this->respond->ok($route);
    }

    public function destroy($id, RouteRepository $repository)
    {
        $route = $repository->findByPublicID($id);

        if (!$route) {
            return $this->respond->notFound('Rota não encontrada.');
        }

        $repository->delete($route);

        return $this->respond->ok($route);
    }
}
