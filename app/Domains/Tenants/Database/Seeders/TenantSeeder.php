<?php

namespace Emtudo\Domains\Tenants\Database\Seeders;

use Emtudo\Domains\Courses\Database\Seeders\CourseSeeder;
use Emtudo\Domains\Courses\Database\Seeders\SubjectSeeder;
use Emtudo\Domains\Tenants\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run()
    {
        CourseSeeder::createByTenant($tenantMaster);
        SubjectSeeder::createByTenant($tenantMaster);

        if ('local' !== env('APP_ENV')) {
            return;
        }

        // create some fake tenants
        $tenants = factory(Tenant::class)->times(5)->create();
        foreach ($tenants as $tenant) {
            CourseSeeder::createByTenant($tenant);
            SubjectSeeder::createByTenant($tenant);
        }
    }

    public static function start()
    {
        $address = [
            'street' => 'Rua X',
            'number' => '100',
            'complement' => null,
            'district' => 'Centro',
            'city' => 'Curitiba',
            'state' => 'PR',
            'zip' => '81000000',
        ];

        $phones = [
            'work' => '41999999999',
            'mobile' => null,
            'other' => null,
        ];

        $tenants = factory(Tenant::class)->create([
            'name' => 'Gabinete do Prefeito',
            'label' => 'Gabinete do Prefeito',
            'email' => 'contato@escola.municipal',
            'country_register' => env('TENANT_COUNTRY_REGISTER', '11111111111111'),
            'address' => $address,
            'phones' => $phones,
        ]);
    }
}
