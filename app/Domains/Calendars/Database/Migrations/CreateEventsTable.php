<?php

namespace Emtudo\Domains\Calendars\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Eventos
        $this->schema->create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenant_id')->index();

            $table->string('label')->index();
            $table->datetime('date')->index();
            $table->text('description')->nullable();
            $table->json('address')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('events');
    }
}
