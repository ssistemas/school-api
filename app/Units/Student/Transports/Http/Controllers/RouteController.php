<?php

namespace Emtudo\Units\Student\Transports\Http\Controllers;

use Emtudo\Domains\Transports\Contracts\RouteRepository;
use Emtudo\Support\Http\Controller;
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
}
