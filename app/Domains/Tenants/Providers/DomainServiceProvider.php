<?php

namespace Emtudo\Domains\Tenants\Providers;

use Emtudo\Domains\Tenants\Contracts;
use Emtudo\Domains\Tenants\Database\Factories;
use Emtudo\Domains\Tenants\Database\Migrations;
use Emtudo\Domains\Tenants\Database\Seeders;
use Emtudo\Domains\Tenants\Events\TenantCreated;
use Emtudo\Domains\Tenants\Repositories;
use Emtudo\Domains\Tenants\Tenant;
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
    protected $alias = 'tenants';

    /**
     * @var array
     */
    public $bindings = [
        Contracts\TenantRepository::class => Repositories\TenantRepository::class,
    ];

    protected $migrations = [
        Migrations\CreateTenantsTable::class,
        Migrations\CreateTenantsUsersTable::class,
    ];

    protected $seeders = [
        Seeders\TenantSeeder::class,
    ];

    protected $factories = [
        Factories\TenantFactory::class,
    ];

    public function boot()
    {
        Tenant::created(function ($tenant) {
            event(new TenantCreated($tenant));
        });
    }
}
