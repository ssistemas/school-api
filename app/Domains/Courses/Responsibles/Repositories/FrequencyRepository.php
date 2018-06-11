<?php

namespace Emtudo\Domains\Courses\Responsibles\Repositories;

use Emtudo\Domains\Courses\Repositories\FrequencyRepository as Repository;
use Emtudo\Domains\Courses\Responsibles\Contracts\FrequencyRepository as Contract;
use Emtudo\Domains\Courses\Responsibles\Frequency;
use Emtudo\Domains\Courses\Responsibles\Transformers\FrequencyTransformer;

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
        $query->whereHas('student', function ($query) {
            $userId = auth()->user()->id;
            $query
                ->where('users.parent1_id', $userId)
                ->orWhere('users.parent2_id', $userId)
                ->orWhere('users.responsible1_id', $userId)
                ->orWhere('users.responsible2_id', $userId);
        });

        return $query;
    }
}
