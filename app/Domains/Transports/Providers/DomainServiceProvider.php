<?php

namespace Emtudo\Domains\Transports\Providers;

use Emtudo\Domains\Transports\Contracts;
use Emtudo\Domains\Transports\Database\Factories;
use Emtudo\Domains\Transports\Database\Migrations;
use Emtudo\Domains\Transports\Database\Seeders;
use Emtudo\Domains\Transports\Repositories;
use Emtudo\Support\Domain\ServiceProvider;

/**
 * Class DomainServiceProvider.
 */
class DomainServiceProvider extends ServiceProvider
{
    protected $subProviders = [
    ];

    /**
     * @var string
     */
    protected $alias = 'transports';

    /**
     * @var array
     */
    public $bindings = [
        Contracts\VehicleRepository::class => Repositories\VehicleRepository::class,
        Contracts\RouteRepository::class => Repositories\RouteRepository::class,
        Contracts\StopRepository::class => Repositories\StopRepository::class,
    ];

    protected $migrations = [
        Migrations\CreateVehiclesTable::class,
        Migrations\CreateRoutesTable::class,
        Migrations\CreateStopsTable::class,
        Migrations\CreateRouteStopTable::class,
        Migrations\CreateVehicleRouteTable::class,
    ];

    protected $seeders = [
        Seeders\VehicleSeeder::class,
        Seeders\RouteSeeder::class,
        Seeders\StopSeeder::class,
    ];

    protected $factories = [
        Factories\VehicleFactory::class,
        Factories\RouteFactory::class,
        Factories\StopFactory::class,
    ];

    public function boot()
    {
    }
}
