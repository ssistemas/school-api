<?php

namespace Emtudo\Domains\Transports\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVehicleRouteTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->schema->create('vehicle_route', function (Blueprint $table) {
            $table->unsignedInteger('route_id')->index();
            $table->unsignedInteger('vehicle_id')->index();

            $table->string('driver', 50)->nullable()->index();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['route_id', 'vehicle_id']);
            $table->index(['route_id', 'vehicle_id', 'driver']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('vehicle_route');
    }
}
