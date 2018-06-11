<?php

namespace Emtudo\Domains\Courses\Providers;

use Emtudo\Domains\Courses\Contracts;
use Emtudo\Domains\Courses\Database\Factories;
use Emtudo\Domains\Courses\Database\Migrations;
use Emtudo\Domains\Courses\Database\Seeders;
use Emtudo\Domains\Courses\Enrollment;
use Emtudo\Domains\Courses\Events\EnrollmentCreated;
use Emtudo\Domains\Courses\Frequency;
use Emtudo\Domains\Courses\Repositories;
use Emtudo\Domains\Courses\Students;
use Emtudo\Domains\Courses\Teachers;
use Emtudo\Support\Domain\ServiceProvider;

/**
 * Class DomainServiceProvider.
 */
class DomainServiceProvider extends ServiceProvider
{
    protected $subProviders = [
        EventServiceProvider::class,
    ];

    /**
     * @var string
     */
    protected $alias = 'transports';

    /**
     * @var array
     */
    public $bindings = [
        Contracts\CourseRepository::class => Repositories\CourseRepository::class,
        Contracts\EnrollmentRepository::class => Repositories\EnrollmentRepository::class,
        Contracts\FrequencyRepository::class => Repositories\FrequencyRepository::class,
        Contracts\GradeRepository::class => Repositories\GradeRepository::class,
        Contracts\GroupRepository::class => Repositories\GroupRepository::class,
        Contracts\QuestionRepository::class => Repositories\QuestionRepository::class,
        Contracts\QuizRepository::class => Repositories\QuizRepository::class,
        Contracts\ScheduleRepository::class => Repositories\ScheduleRepository::class,
        Contracts\SkillRepository::class => Repositories\SkillRepository::class,
        Contracts\SubjectRepository::class => Repositories\SubjectRepository::class,

        Students\Contracts\FrequencyRepository::class => Students\Repositories\FrequencyRepository::class,
        Students\Contracts\GradeRepository::class => Students\Repositories\GradeRepository::class,
        Students\Contracts\GroupRepository::class => Students\Repositories\GroupRepository::class,

        Responsibles\Contracts\FrequencyRepository::class => Responsibles\Repositories\FrequencyRepository::class,
        Responsibles\Contracts\GradeRepository::class => Responsibles\Repositories\GradeRepository::class,
        Responsibles\Contracts\GroupRepository::class => Responsibles\Repositories\GroupRepository::class,

        Teachers\Contracts\CourseRepository::class => Teachers\Repositories\CourseRepository::class,
        Teachers\Contracts\FrequencyRepository::class => Teachers\Repositories\FrequencyRepository::class,
        Teachers\Contracts\GradeRepository::class => Teachers\Repositories\GradeRepository::class,
        Teachers\Contracts\GroupRepository::class => Teachers\Repositories\GroupRepository::class,
        Teachers\Contracts\QuizRepository::class => Teachers\Repositories\QuizRepository::class,
        Teachers\Contracts\SubjectRepository::class => Teachers\Repositories\SubjectRepository::class,
    ];

    protected $migrations = [
        Migrations\CreateCoursesTable::class,
        Migrations\CreateEnrollmentsTable::class,
        Migrations\CreateFrequenciesTable::class,
        Migrations\CreateGradesTable::class,
        Migrations\CreateGroupsTable::class,
        Migrations\CreateQuestionsTable::class,
        Migrations\CreateQuizzesTable::class,
        Migrations\CreateSchedulesTable::class,
        Migrations\CreateSkillsTable::class,
        Migrations\CreateSubjectsTable::class,
    ];

    protected $seeders = [
        Seeders\CourseSeeder::class,
        Seeders\EnrollmentSeeder::class,
        Seeders\FrequencySeeder::class,
        Seeders\GradeSeeder::class,
        Seeders\GroupSeeder::class,
        Seeders\QuestionSeeder::class,
        Seeders\QuizSeeder::class,
        Seeders\ScheduleSeeder::class,
        Seeders\SkillSeeder::class,
        Seeders\SubjectSeeder::class,
    ];

    protected $factories = [
        Factories\CourseFactory::class,
        Factories\EnrollmentFactory::class,
        Factories\FrequencyFactory::class,
        Factories\GradeFactory::class,
        Factories\GroupFactory::class,
        Factories\QuestionFactory::class,
        Factories\QuizFactory::class,
        Factories\ScheduleFactory::class,
        Factories\SkillFactory::class,
        Factories\SubjectFactory::class,
    ];

    public function boot()
    {
        Enrollment::created(function ($enrollment) {
            event(new EnrollmentCreated($enrollment));
        });

        Frequency::creating(function ($schedule) {
            FrequencyCreating($schedule);
        });
    }
}
