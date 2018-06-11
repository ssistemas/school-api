<?php

namespace Emtudo\Units\Search\Transports\Http\Controllers;

use Emtudo\Domains\Transports\Contracts\RouteRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param RouteRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, RouteRepository $repository)
    {
        $data = [];
        if ($request->has('search')) {
            $data = $request->get('search');
        }
        if (!is_array($data)) {
            $data = [$data];
        }
        $routes = $repository->getAllRoutesByParams($data, $this->itemsPerPage, $this->pagination);

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
        return $this->respond->ok($route);
    }
}
