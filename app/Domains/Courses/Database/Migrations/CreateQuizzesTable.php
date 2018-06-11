<?php

namespace Emtudo\Domains\Courses\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Provas
        $this->schema->create('quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');
            // tenant_id apenas um facilitador, não precisa desse campo
            $table->unsignedInteger('tenant_id')->index();

            $table->uuid('schedule_id')->index();
            $table->enum('kind', ['proof', 'work', 'cultural_fair', 'others'])->default('proof');

            $table->string('label')->index();
            $table->integer('score');
            $table->date('date')->index();

            $table->boolean('proof_of_recovery')->default(false); // Prova de recuperação

            $table->timestamps();
            $table->softDeletes();

            $table->index(['schedule_id', 'label']);
            $table->index(['schedule_id', 'kind']);
            $table->index(['schedule_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('quizzes');
    }
}
