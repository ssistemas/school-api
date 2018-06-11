<?php

namespace Emtudo\Units\School\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\ManagerRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Users\Http\Requests\Managers\CreateManagerRequest;
use Emtudo\Units\School\Users\Http\Requests\Managers\UpdateManagerRequest;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param ManagerRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, ManagerRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $managers = $repository->with(['tenants'])->getAllManagersByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($managers);
    }

    /**
     * @param string            $id
     * @param ManagerRepository $repository
     */
    public function show($id, ManagerRepository $repository)
    {
        $manager = $repository->findByPublicID($id);

        if (!$manager) {
            return $this->respond->notFound('Diretor não encontrado.');
        }

        return $this->respond->ok($manager, null, ['profiles', 'have_profiles']);
    }

    /**
     * @param CreateManagerRequest $request
     * @param ManagerRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateManagerRequest $request, ManagerRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $manager = $repository->create($data);

        return $this->respond->ok($manager);
    }

    /**
     * @param string               $id
     * @param UpdateManagerRequest $request
     * @param ManagerRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateManagerRequest $request, ManagerRepository $repository)
    {
        $manager = $repository->findByPublicID($id);

        if (!$manager) {
            return $this->respond->notFound('Diretor não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($manager, $data);

        return $this->respond->ok($manager);
    }

    public function destroy($id, ManagerRepository $repository)
    {
        $manager = $repository->findByPublicID($id);

        if (!$manager) {
            return $this->respond->notFound('Diretor não encontrado.');
        }

        $deleted = $repository->delete($manager);

        if (!$deleted) {
            return $this->respond->error('Falha ao excluir responsável');
        }

        return $this->respond->ok($manager);
    }
}
