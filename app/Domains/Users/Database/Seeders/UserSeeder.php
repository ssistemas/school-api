<?php

namespace Emtudo\Domains\Users\Database\Seeders;

use Carbon\Carbon;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        if ('local' !== env('APP_ENV')) {
            return;
        }

        // test users
        factory(User::class)->times(30)->create();
    }

    public static function start()
    {
        $tenant = Tenant::first();

        $user = factory(User::class)->create([
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' => env('ADMIN_PASSWORD'),
            'birthdate' => Carbon::now()->subYears(rand(18, 45))->format('Y-m-d'),
            'last_tenant' => $tenant->id,
            'master' => true,
            'is_admin' => true,
        ]);

        $tenant->users()->attach($user);
    }

    protected function createMainTenantTestUsers()
    {
        if ('local' !== env('APP_ENV')) {
            return;
        }

        $tenant = Tenant::first();
        $user = factory(User::class)->create([
            'email' => 'staff@user.com',
            'password' => 'abc123',
            'birthdate' => Carbon::now()->subYears(rand(18, 45))->format('Y-m-d'),
            'last_tenant' => $tenant->id,
        ]);

        $tenant->users()->attach($user);

        // User
        $user = factory(User::class)->create([
            'email' => 'user@user.com',
            'birthdate' => Carbon::now()->subYears(rand(18, 45))->format('Y-m-d'),
            'password' => 'abc123',
            'last_tenant' => $tenant->id,
        ]);

        $tenant->users()->attach($user);
    }
}
