<?php

namespace Emtudo\Domains\Courses\Repositories;

use Emtudo\Domains\Courses\Contracts\QuizRepository as QuizRepositoryContract;
use Emtudo\Domains\Courses\Queries\QuizQueryFilter;
use Emtudo\Domains\Courses\Quiz;
use Emtudo\Domains\Courses\Transformers\QuizTransformer;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class QuizRepository extends TenantRepository implements QuizRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Quiz::class;

    /**
     * @var string
     */
    protected $transformerClass = QuizTransformer::class;

    public function newQuery()
    {
        $query = parent::newQuery()->orderBy('label');
        $user = auth()->user();
        // if ($user->is_admin) {
        //     return $query;
        // }

        $query
            ->whereHas('schedule.skill', function ($query) use ($user) {
                return $query
                    ->select('id')
                    ->where('teacher_id', $user->id);
            });

        return $query;
    }

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllQuizzesByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new QuizQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }
}
