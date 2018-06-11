<?php

namespace Emtudo\Domains\Courses\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Notas
        $this->schema->create('grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            // tenant_id apenas um facilitador, não precisa desse campo
            $table->unsignedInteger('tenant_id')->index();

            $table->unsignedInteger('student_id')->index();
            $table->unsignedInteger('quiz_id')->index();

            $table->mediumInteger('value');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['student_id', 'quiz_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('grades');
    }
}
