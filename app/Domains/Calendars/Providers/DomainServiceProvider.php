<?php

namespace Emtudo\Domains\Calendars\Providers;

use Emtudo\Domains\Calendars\Contracts;
use Emtudo\Domains\Calendars\Database\Factories;
use Emtudo\Domains\Calendars\Database\Migrations;
use Emtudo\Domains\Calendars\Database\Seeders;
use Emtudo\Domains\Calendars\Repositories;
use Emtudo\Support\Domain\ServiceProvider;

/**
 * Class DomainServiceProvider.
 */
class DomainServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $alias = 'calendars';

    /**
     * @var array
     */
    public $bindings = [
        Contracts\CalendarRepository::class => Repositories\CalendarRepository::class,
        Contracts\EventRepository::class => Repositories\EventRepository::class,
        Contracts\SchoolDayRepository::class => Repositories\SchoolDayRepository::class,
        Contracts\TwoMonthRepository::class => Repositories\TwoMonthRepository::class,
    ];

    protected $migrations = [
        Migrations\CreateCalendarsTable::class,
        Migrations\CreateEventsTable::class,
        Migrations\CreateTwoMonthsTable::class,
        Migrations\CreateSchoolDaysTable::class,
    ];

    protected $seeders = [
        Seeders\CalendarSeeder::class,
        Seeders\EventSeeder::class,
        Seeders\SchoolDaySeeder::class,
    ];

    protected $factories = [
        Factories\CalendarFactory::class,
        Factories\EventFactory::class,
        Factories\SchoolDayFactory::class,
    ];
}
