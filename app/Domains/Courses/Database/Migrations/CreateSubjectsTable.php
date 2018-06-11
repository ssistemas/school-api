<?php

namespace Emtudo\Domains\Courses\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Matérias
        $this->schema->create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenant_id')->index();

            $table->string('label')->index();

            // $table->float('pass_score')->nullable();

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
        $this->schema->drop('subjects');
    }
}
