<?php

namespace Emtudo\Units\School\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\ResponsibleRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Users\Http\Requests\Responsibles\CreateResponsibleRequest;
use Emtudo\Units\School\Users\Http\Requests\Responsibles\UpdateResponsibleRequest;
use Illuminate\Http\Request;

class ResponsibleController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param ResponsibleRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, ResponsibleRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $responsibles = $repository->with(['tenants'])->getAllResponsiblesByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($responsibles);
    }

    /**
     * @param string                $id
     * @param ResponsibleRepository $repository
     */
    public function show($id, ResponsibleRepository $repository)
    {
        $responsible = $repository->findByPublicID($id);

        if (!$responsible) {
            return $this->respond->notFound('Responsável não encontrado.');
        }

        return $this->respond->ok($responsible, null, ['profiles', 'have_profiles']);
    }

    /**
     * @param CreateResponsibleRequest $request
     * @param ResponsibleRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateResponsibleRequest $request, ResponsibleRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $responsible = $repository->create($data);

        return $this->respond->ok($responsible);
    }

    /**
     * @param string                   $id
     * @param UpdateResponsibleRequest $request
     * @param ResponsibleRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateResponsibleRequest $request, ResponsibleRepository $repository)
    {
        $responsible = $repository->findByPublicID($id);

        if (!$responsible) {
            return $this->respond->notFound('Responsável não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($responsible, $data);

        return $this->respond->ok($responsible);
    }

    public function destroy($id, ResponsibleRepository $repository)
    {
        $responsible = $repository->findByPublicID($id);

        if (!$responsible) {
            return $this->respond->notFound('Responsável não encontrado.');
        }

        $deleted = $repository->delete($responsible);

        if (!$deleted) {
            return $this->respond->error('Falha ao excluir responsável');
        }

        return $this->respond->ok($deleted);
    }
}
