<?php

namespace Emtudo\Units\Teacher\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Teachers\Contracts\FrequencyRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\Teacher\Courses\Http\Requests\Frequencies\CreateFrequencyRequest;
use Emtudo\Units\Teacher\Courses\Http\Requests\Frequencies\CreateFrequencySeveralRequest;
use Emtudo\Units\Teacher\Courses\Http\Requests\Frequencies\UpdateFrequencyRequest;
use Illuminate\Http\Request;

class FrequencyController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
        'group_id' => 'id',
        'school_day_id' => 'id',
        'students' => [
            'student_id' => 'id',
        ],
    ];

    /**
     * @param CourseRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, FrequencyRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $frequencies = $repository->getAllFrequenciesByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($frequencies, null, $this->includes);
    }

    /**
     * @param string              $id
     * @param FrequencyRepository $repository
     */
    public function show($id, FrequencyRepository $repository)
    {
        $frequency = $repository->findById($id);

        if (!$frequency) {
            return $this->respond->notFound('Frequência não encontrada.');
        }

        return $this->respond->ok($frequency, null, $this->includes);
    }

    /**
     * @param CreateFrequencyRequest $request
     * @param FrequencyRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSeveral(CreateFrequencySeveralRequest $request, FrequencyRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $saved = $repository->createMany($data);

        return $this->respond->ok([], 'Salvo scom sucesso!');
    }

    /**
     * @param CreateFrequencyRequest $request
     * @param FrequencyRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateFrequencyRequest $request, FrequencyRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $frequency = $repository->create($data);

        return $this->respond->ok($frequency);
    }

    /**
     * @param string                 $id
     * @param UpdateFrequencyRequest $request
     * @param FrequencyRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateFrequencyRequest $request, FrequencyRepository $repository)
    {
        $frequency = $repository->findById($id);

        if (!$frequency) {
            return $this->respond->notFound('Frequência não encontrada.');
        }

        $data = $this->cleanFields($request->only('present', 'justified_absence'));

        $repository->update($frequency, $data);

        return $this->respond->ok($frequency);
    }

    public function destroy($id, FrequencyRepository $repository)
    {
        $frequency = $repository->findById($id);

        if (!$frequency) {
            return $this->respond->notFound('Frequência não encontrada.');
        }

        $repository->delete($frequency);

        return $this->respond->ok($frequency);
    }
}
