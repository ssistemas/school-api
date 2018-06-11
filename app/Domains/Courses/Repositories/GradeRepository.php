<?php

namespace Emtudo\Domains\Courses\Repositories;

use Emtudo\Domains\Calendars\TwoMonth;
use Emtudo\Domains\Courses\Contracts\GradeRepository as GradeRepositoryContract;
use Emtudo\Domains\Courses\Grade;
use Emtudo\Domains\Courses\Queries\GradeQueryFilter;
use Emtudo\Domains\Courses\Transformers\GradeTransformer;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class GradeRepository extends TenantRepository implements GradeRepositoryContract
{
    use Traits\Grades\StudentsTrait;
    use Traits\Grades\CreateManyTrait;

    /**
     * @var string
     */
    protected $modelClass = Grade::class;

    /**
     * @var string
     */
    protected $transformerClass = GradeTransformer::class;

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllGradesByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new GradeQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    public function getBestAverages(int $year, ?int $twoMonth = null, $take = 5, $paginate = false)
    {
        return $this->getAverages($year, $twoMonth, $take, $paginate, 'DESC');
    }

    public function getWorstAverages(int $year, ?int $twoMonth = null, $take = 5, $paginate = false)
    {
        return $this->getAverages($year, $twoMonth, $take, $paginate, 'ASC');
    }

    protected function getAverages(int $year, ?int $twoMonth = null, $take = 5, $paginate = false, $order = 'DESC')
    {
        $query = $this->newQuery();
        $query->whereHas('quiz', function ($query) use ($year, $twoMonth) {
            $query
                ->select('id')
                ->whereRaw('YEAR(`quizzes`.`date`) = ?', $year);
            if ($twoMonth and $twoMonth > 0 and $twoMonth < 5) {
                $dates = TwoMonth::getTwoMonthByYear($year);
                $start = "start{$twoMonth}";
                $end = "end{$twoMonth}";
                $first = $dates->$start;
                $second = $dates->$end;
                $query->whereBetween('quizzes.date', [$first, $second]);
            }
        })
        ->selectRaw('SUM(grades.value) as grade')
        ->addSelect('student_id')
        ->groupBy('grades.student_id')
        ->orderBy('grade', $order)
        ->with(['student']);

        return $this->doQuery($query, $take, $paginate);
    }
}
