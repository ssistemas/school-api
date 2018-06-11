<?php

namespace Emtudo\Domains\Courses\Repositories;

use Emtudo\Domains\Courses\Contracts\QuestionRepository as QuestionRepositoryContract;
use Emtudo\Domains\Courses\Queries\QuestionQueryFilter;
use Emtudo\Domains\Courses\Question;
use Emtudo\Domains\Courses\Transformers\QuestionTransformer;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class QuestionRepository extends TenantRepository implements QuestionRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Question::class;

    /**
     * @var string
     */
    protected $transformerClass = QuestionTransformer::class;

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllQuestionsByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new QuestionQueryFilter($this->newQuestionQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    /**
     * get new query on those who are transports.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    protected function newQuestionQuery()
    {
        return $this->newQuery();
    }
}
