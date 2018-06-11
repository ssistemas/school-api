<?php

namespace Emtudo\Domains\Courses\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Habilidades dos professores
        $this->schema->create('skills', function (Blueprint $table) {
            $table->increments('id');
            // tenant_id apenas um facilitador, não precisa desse campo
            $table->unsignedInteger('tenant_id')->index();

            $table->unsignedBigInteger('teacher_id');
            $table->unsignedInteger('subject_id');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['teacher_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('skills');
    }
}
