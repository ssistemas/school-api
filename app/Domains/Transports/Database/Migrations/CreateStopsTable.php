<?php

namespace Emtudo\Domains\Transports\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStopsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->schema->create('stops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenant_id')->index();

            $table->string('label', 60)->index();
            $table->json('address')->nullable();

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
        $this->schema->drop('stops');
    }
}
