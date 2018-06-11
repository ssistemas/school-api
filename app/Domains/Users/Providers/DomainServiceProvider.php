<?php

namespace Emtudo\Domains\Users\Providers;

use Emtudo\Domains\Users\Contracts;
use Emtudo\Domains\Users\Database\Factories;
use Emtudo\Domains\Users\Database\Migrations;
use Emtudo\Domains\Users\Database\Seeders;
use Emtudo\Domains\Users\Repositories;
use Emtudo\Domains\Users\Responsibles;
use Emtudo\Support\Domain\ServiceProvider;

/**
 * Class DomainServiceProvider.
 */
class DomainServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $alias = 'users';

    /**
     * @var array
     */
    public $bindings = [
        Contracts\ManagerRepository::class => Repositories\ManagerRepository::class,
        Contracts\ResponsibleRepository::class => Repositories\ResponsibleRepository::class,
        Contracts\StudentRepository::class => Repositories\StudentRepository::class,
        Contracts\TeacherRepository::class => Repositories\TeacherRepository::class,
        Contracts\UserRepository::class => Repositories\UserRepository::class,

        Responsibles\Contracts\StudentRepository::class => Responsibles\Repositories\StudentRepository::class,
    ];

    protected $migrations = [
        Migrations\CreateUsersTable::class,
        Migrations\CreatePasswordResetsTable::class,
    ];

    protected $seeders = [
        Seeders\UserSeeder::class,
    ];

    protected $factories = [
        Factories\UserFactory::class,
    ];
}
