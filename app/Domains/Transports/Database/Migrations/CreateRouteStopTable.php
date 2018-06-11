<?php

namespace Emtudo\Domains\Transports\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRouteStopTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->schema->create('route_stop', function (Blueprint $table) {
            $table->unsignedInteger('route_id')->index();
            $table->unsignedInteger('stop_id')->index();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['route_id', 'stop_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('route_stop');
    }
}
