<?php

namespace Emtudo\Domains\Courses\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Horários
        $this->schema->create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // tenant_id apenas um facilitador, não precisa desse campo
            $table->unsignedInteger('tenant_id')->index();

            $table->unsignedInteger('group_id')->index();
            $table->unsignedInteger('skill_id')->index();

            $table->enum('day', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'])->index();
            $table->unsignedTinyInteger('index');

            $table->time('hour_start');
            $table->time('hour_end');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['group_id', 'skill_id']);
            $table->index(['group_id', 'skill_id', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('schedules');
    }
}
