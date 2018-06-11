<?php

namespace Emtudo\Domains\Files\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->schema->create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenant_id')->index();
            $table->string('fileable_id', 36)->nullable()->index();
            $table->string('fileable_type')->nullable()->index();
            $table->string('kind')->nullable()->index();
            $table->string('label');
            $table->string('uuid');
            $table->string('mime')->nullable();
            $table->string('size')->nullable();
            $table->string('extension')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['tenant_id', 'kind']);
            $table->index(['tenant_id', 'label']);
            $table->index(['tenant_id', 'kind', 'label']);
            $table->index(['tenant_id', 'uuid']);
            $table->index(['tenant_id', 'fileable_id', 'fileable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('files');
    }
}
