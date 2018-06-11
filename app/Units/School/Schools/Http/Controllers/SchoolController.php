<?php

namespace Emtudo\Units\School\Schools\Http\Controllers;

use Emtudo\Domains\Tenants\Contracts\TenantRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Schools\Http\Requests\CreateSchoolRequest;
use Emtudo\Units\School\Schools\Http\Requests\UpdateSchoolRequest;
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

    /**
     * @param CreateSchoolRequest $request
     * @param TenantRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSchoolRequest $request, TenantRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $school = $repository->create($data);

        return $this->respond->ok($school);
    }

    /**
     * @param string              $id
     * @param UpdateSchoolRequest $request
     * @param TenantRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateSchoolRequest $request, TenantRepository $repository)
    {
        $school = $repository->findByPublicID($id);

        if (!$school) {
            return $this->respond->notFound('Escola não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($school, $data);

        return $this->respond->ok($school, null);
    }

    public function destroy($id, TenantRepository $repository)
    {
        $school = $repository->findByPublicID($id);

        if (!$school) {
            return $this->respond->notFound('Escola não encontrado.');
        }

        $deleted = $repository->delete($school);

        if (!$deleted) {
            return $this->respond->error('Falha ao excluir escola');
        }

        return $this->respond->ok($deleted);
    }
}
