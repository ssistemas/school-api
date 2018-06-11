<?php

namespace Emtudo\Domains\Courses\Teachers\Repositories;

use Emtudo\Domains\Courses\Repositories\FrequencyRepository as Repository;
use Emtudo\Domains\Courses\Teachers\Contracts\FrequencyRepository as Contract;
use Emtudo\Domains\Courses\Teachers\Frequency;
use Emtudo\Domains\Courses\Teachers\Transformers\FrequencyTransformer;

class FrequencyRepository extends Repository implements Contract
{
    /**
     * @var string
     */
    protected $modelClass = Frequency::class;

    /**
     * @var string
     */
    protected $transformerClass = FrequencyTransformer::class;

    public function newQuery()
    {
        $query = parent::newQuery();
        $query->whereHas('schedule.skill', function ($query) {
            $user = auth()->user();
            $query->where('teacher_id', $user->id);
        });

        return $query;
    }
}
