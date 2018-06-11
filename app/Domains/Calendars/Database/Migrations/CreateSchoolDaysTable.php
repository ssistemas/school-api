<?php

namespace Emtudo\Domains\Calendars\Database\Migrations;

use Emtudo\Domains\Calendars\Database\Seeders\SchoolDaySeeder;
use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSchoolDaysTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Dias letivos
        $this->schema->create('school_days', function (Blueprint $table) {
            $table->increments('id');

            $table->date('date')->unique();
            $table->boolean('school_day')->default(true);
            $table->string('label')->nullable();

            $table->timestamps();

            $table->index(['date', 'school_day']);
        });

        SchoolDaySeeder::createSchoolDays();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('school_days');
    }
}
