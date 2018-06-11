<?php

namespace Emtudo\Domains\Courses\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Cursos
        $this->schema->create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenant_id')->index();

            $table->string('label')->index();
            $table->tinyInteger('min_frequency')->default(70);
            $table->tinyInteger('min_grade')->default(60);

            // $table->tinyInteger('max_period')->nullable(); // 1 to 12
            // $table->tinyInteger('division_period')->nullable(); // 1 to 12 - 12, 6, 4, 3, 2, 1

            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'label']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('courses');
    }
}
