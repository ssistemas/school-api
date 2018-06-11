<?php

namespace Emtudo\Domains\Courses\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Matrículas
        $this->schema->create('enrollments', function (Blueprint $table) {
            $table->bigIncrements('id');

            // tenant_id apenas um facilitador, não precisa desse campo
            $table->unsignedInteger('tenant_id')->index();

            $table->unsignedBigInteger('student_id')->index();
            $table->unsignedInteger('group_id')->index();
            $table->unsignedInteger('route_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['group_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('enrollments');
    }
}
