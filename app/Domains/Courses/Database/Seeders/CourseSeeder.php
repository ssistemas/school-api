<?php

namespace Emtudo\Domains\Courses\Database\Seeders;

use Emtudo\Domains\Courses\Course;
use Emtudo\Domains\Tenants\Tenant;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        // $tenants = Tenant::all();
        // foreach ($tenants as $tenant) {
        //     self::createByTenant($tenant);
        // }
    }

    public static function createByTenant(Tenant $tenant)
    {
        $courses = [
            'Primeira série',
            'Segunda série',
            'Terceira série',
            'Quarta série',
            'Quinta série',
            'Sexta série',
            'Sétima série',
            'Oitava série',
            'Nona série',
        ];

        array_map(function ($course) use ($tenant) {
            factory(Course::class)->create([
                'tenant_id' => $tenant->id,
                'label' => $course,
            ]);
        }, $courses);
    }
}
