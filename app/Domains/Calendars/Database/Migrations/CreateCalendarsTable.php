<?php

namespace Emtudo\Domains\Calendars\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Calendário
        $this->schema->create('calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenant_id')->index();

            $table->mediumInteger('year')->index();
            $table->string('label')->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('calendars');
    }
}
