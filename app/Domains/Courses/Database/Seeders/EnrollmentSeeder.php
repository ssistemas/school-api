<?php

namespace Emtudo\Domains\Courses\Database\Seeders;

use Emtudo\Domains\Courses\Enrollment;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run()
    {
        if ('local' !== env('APP_ENV')) {
            return;
        }
        factory(Enrollment::class)->create([
            'student_id' => 1,
            'group_id' => 1,
            'tenant_id' => 1,
        ]);
    }
}
