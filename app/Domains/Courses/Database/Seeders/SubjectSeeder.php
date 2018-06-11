<?php

namespace Emtudo\Domains\Courses\Database\Seeders;

use Emtudo\Domains\Courses\Subject;
use Emtudo\Domains\Tenants\Tenant;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
    }

    public static function createByTenant(Tenant $tenant)
    {
        $subjects = [
            'Artes',
            'Biologia',
            'Ciências',
            'Disciplina',
            'Educação Física',
            'Espanhol',
            'Geografia',
            'História',
            'Inglês',
            'Libras',
            'Literatura',
            'Matemática',
            'Português',
            'Psicologia',
            'Química',
            'Sociologia',
        ];

        array_map(function ($subject) use ($tenant) {
            factory(Subject::class)->create([
                'tenant_id' => $tenant->id,
                'label' => $subject,
            ]);
        }, $subjects);
    }
}
