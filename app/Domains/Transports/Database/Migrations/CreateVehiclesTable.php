<?php

namespace Emtudo\Domains\Transports\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->schema->create('vehicles', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedInteger('tenant_id')->index();

            $table->string('label', 30)->index();
            $table->string('board', 8);
            $table->unsignedTinyInteger('capacity');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'label']);
            $table->index(['tenant_id', 'board']);
            $table->index(['tenant_id', 'capacity']);
            $table->index(['tenant_id', 'label', 'board']);
            $table->index(['tenant_id', 'label', 'capacity']);
            $table->index(['tenant_id', 'label', 'board', 'capacity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('vehicles');
    }
}
