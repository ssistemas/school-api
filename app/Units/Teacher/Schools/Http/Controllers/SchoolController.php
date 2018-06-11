<?php

namespace Emtudo\Units\Teacher\Schools\Http\Controllers;

use Emtudo\Domains\Tenants\Contracts\TenantRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
        'director_id' => 'id',
    ];

    /**
     * @param TenantRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, TenantRepository $repository)
    {
        $params = $this->cleanFields($request->all());

        $schools = $repository->getAllTenantsByParams($params, $this->itemsPerPage, true);

        return $this->respond->ok($schools, null, ['director']);
    }

    /**
     * @param string           $id
     * @param TenantRepository $repository
     */
    public function show($id, TenantRepository $repository)
    {
        $school = $repository->findByPublicID($id);

        if (!$school) {
            return $this->respond->notFound('Escola não encontrado.');
        }

        return $this->respond->ok($school);
    }
}
