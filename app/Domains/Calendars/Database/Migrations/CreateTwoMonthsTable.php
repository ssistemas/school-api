<?php

namespace Emtudo\Domains\Calendars\Database\Migrations;

use Carbon\Carbon;
use Emtudo\Domains\Calendars\TwoMonth;
use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTwoMonthsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Dias letivos
        $this->schema->create('two_months', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->date('start1');
            $table->date('end1');
            $table->date('start2');
            $table->date('end2');
            $table->date('start3');
            $table->date('end3');
            $table->date('start4');
            $table->date('end4');

            $table->timestamps();

            $table->index(['id', 'start1', 'end1']);
            $table->index(['id', 'start2', 'end2']);
            $table->index(['id', 'start3', 'end3']);
            $table->index(['id', 'start4', 'end4']);
        });

        // 1º Bimestre 2018: 1/Fev a20/Abr = 53 dias letivos
        // 2º Bimestre 2018:  21/Abr a 9/Jul = 53 dias letivos
        // 3º Bimestre 2018:  30/Jul a 3/Out =  48 dias letivos
        // 4º Bimestre 2018:  4/Out a 14/Dez =  47 dias letivos

        $date = Carbon::create(2018, 01, 01, 0);

        while ('2079-01-01' !== $date->format('Y-m-d')) {
            TwoMonth::create([
                'id' => $date->year,
                'start1' => "{$date->year}-02-01",
                'end1' => "{$date->year}-04-20", // 53 dias letivos
                'start2' => "{$date->year}-04-21",
                'end2' => "{$date->year}-07-09", // 53 dias letivos
                'start3' => "{$date->year}-07-30",
                'end3' => "{$date->year}-10-03", // 48 dias letivos
                'start4' => "{$date->year}-10-04",
                'end4' => "{$date->year}-12-14", // 47 dias letivos
            ]);
            $date->addYear();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('two_months');
    }
}
