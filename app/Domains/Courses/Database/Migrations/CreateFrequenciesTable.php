<?php

namespace Emtudo\Domains\Courses\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFrequenciesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Frequências
        // Uma por horário
        $this->schema->create('frequencies', function (Blueprint $table) {
            $table->uuid('id')->index();
            // tenant_id apenas um facilitador, não precisa desse campo
            $table->unsignedInteger('tenant_id')->index();

            $table->uuid('schedule_id')->index();
            $table->unsignedInteger('subject_id')->index(); // Preciso pois a disciplina no horário pode ser alterada.

            $table->unsignedInteger('school_day_id')->index();
            $table->unsignedBigInteger('student_id')->index();

            $table->boolean('present')->default(true);
            $table->boolean('justified_absence')->nullable()->default(false);

            $table->timestamps();

            $table->index('updated_at');

            $table->unique('id');
            $table->unique(['schedule_id', 'school_day_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('frequencies');
    }
}
