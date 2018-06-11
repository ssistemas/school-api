<?php

namespace Emtudo\Domains\Courses\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Questões das provas
        $this->schema->create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            // tenant_id apenas um facilitador, não precisa desse campo
            $table->unsignedInteger('tenant_id')->index();

            $table->unsignedInteger('quiz_id')->index();

            $table->text('ask');
            $table->json('options')->nullable();
            $table->string('answer')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('questions');
    }
}
