<?php

namespace Emtudo\Domains\Courses\Students\Repositories;

use Emtudo\Domains\Courses\Repositories\FrequencyRepository as Repository;
use Emtudo\Domains\Courses\Students\Contracts\FrequencyRepository as Contract;
use Emtudo\Domains\Courses\Students\Frequency;
use Emtudo\Domains\Courses\Students\Transformers\FrequencyTransformer;

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
        $user = auth()->user();
        $query = parent::newQuery();
        $query->where('frequencies.student_id', $user->id);

        return $query;
    }
}
