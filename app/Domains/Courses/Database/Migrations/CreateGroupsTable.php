<?php

namespace Emtudo\Domains\Courses\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Turmas
        $this->schema->create('groups', function (Blueprint $table) {
            $table->increments('id');
            // tenant_id apenas um facilitador, não precisa desse campo
            $table->unsignedInteger('tenant_id')->index();

            $table->unsignedInteger('course_id')->index();

            $table->string('label')->index();
            $table->mediumInteger('year')->index();

            $table->mediumInteger('max_students');
            // $table->tinyInteger('pass_score')->nullable();
            // $table->tinyInteger('period');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'label']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('groups');
    }
}
