<?php

namespace Emtudo\Units\Search\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\CourseRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class FrequencyController extends Controller
{
    /**
     * @param CourseRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, FrequencyRepository $repository)
    {
        $params = $request->all();
        $frequencies = $repository->getAllFrequenciesByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($frequencies);
    }

    /**
     * @param string              $id
     * @param FrequencyRepository $repository
     */
    public function show($id, FrequencyRepository $repository)
    {
        $frequency = $repository->findByPublicID($id);

        if (!$frequency) {
            return $this->respond->notFound('Frequência não encontrada.');
        }

        return $this->respond->ok($frequency);
    }
}
