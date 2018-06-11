<?php

namespace Emtudo\Units\School\Dashboard\Http\Controllers;

use Carbon\Carbon;
use Emtudo\Domains\Courses\Repositories\FrequencyRepository;
use Emtudo\Domains\Courses\Repositories\GradeRepository;
use Emtudo\Domains\Courses\Repositories\GroupRepository;
use Emtudo\Domains\Courses\Transformers\FrequencyTopAbsenceTransformer;
use Emtudo\Domains\Courses\Transformers\GradeAverageTransformer;
use Emtudo\Domains\Transports\Repositories\VehicleRepository;
use Emtudo\Domains\Users\Repositories\StudentRepository;
use Emtudo\Domains\Users\Repositories\TeacherRepository;
use Emtudo\Domains\Users\Repositories\UserRepository;
use Emtudo\Domains\Users\Transformers\UserBirthdayTransformer;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->get('year', date('Y'));
        $twoMonth = (int) $request->get('two_month', 0);
        $birthday = $request->get('birthday', 'today');

        return $this->respond->ok([
            'students' => $this->getTotalStudents(),
            'teachers' => $this->getTotalTeachers(),
            'available_vacancies' => $this->getAvailableVacancies($year),
            'vehicles' => $this->getTotalVehicle(),
            'birthdays' => $this->getBirthdays($birthday),
            'years' => $this->getYears(),
            'frequencies' => $this->getFrequencies($year),
            'best_averages' => $this->getBestAverages($year, $twoMonth),
            'worst_averages' => $this->getWorstAverages($year, $twoMonth),
            'top_absences' => $this->getTopAbsences($year, $twoMonth),
        ]);
    }

    protected function getTotalStudents()
    {
        return (app()->make(StudentRepository::class))->count();
    }

    protected function getTotalTeachers()
    {
        return (app()->make(TeacherRepository::class))->count();
    }

    protected function getAvailableVacancies($year = null)
    {
        return (app()->make(GroupRepository::class))->getAvailableVacancies($year);
    }

    protected function getTotalVehicle()
    {
        return (app()->make(VehicleRepository::class))->count();
    }

    protected function getBirthdays(string $when = 'today', $take = false, $paginate = false)
    {
        $repository = app()->make(UserRepository::class);
        $birthdays = $repository->getBirthdays($when, $take, $paginate);

        $result = $repository->transformCollection($birthdays, $paginate, [], new UserBirthdayTransformer())->toArray();

        return $result['data'] ?? [];
    }

    protected function getYears()
    {
        $years = [];
        $year = Carbon::now()->year;
        $lastYear = Carbon::now()->year - 1;
        if (Carbon::now()->month >= 10) {
            ++$year;
        }
        while ($year >= 2018) {
            $years[] = $year;
            --$year;
        }

        return $years;
    }

    protected function getFrequencies(int $year = null)
    {
        return (app()->make(FrequencyRepository::class))->getFrequenciesByYear($year);
    }

    protected function getBestAverages(int $year = null, ?int $twoMonth = null)
    {
        $repository = app()->make(GradeRepository::class);
        $averages = $repository->getBestAverages($year, $twoMonth);
        $averages = $repository->transformCollection($averages, false, ['student'], new GradeAverageTransformer());

        return $averages->toArray()['data'];
    }

    protected function getWorstAverages(int $year = null, ?int $twoMonth = null)
    {
        $repository = app()->make(GradeRepository::class);
        $averages = $repository->getWorstAverages($year, $twoMonth);
        $averages = $repository->transformCollection($averages, false, ['student'], new GradeAverageTransformer());

        return $averages->toArray()['data'];
    }

    protected function getTopAbsences(int $year = null, ?int $twoMonth = null)
    {
        $repository = app()->make(FrequencyRepository::class);
        $topAbsences = $repository->getTopAbsences($year, $twoMonth);
        $topAbsences = $repository->transformCollection($topAbsences, false, ['student'], new FrequencyTopAbsenceTransformer());

        return $topAbsences->toArray()['data'];
    }
}
