<?php

namespace Emtudo\Domains\Tenants\Database\Migrations;

use Emtudo\Domains\Tenants\Database\Seeders\TenantSeeder;
use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->schema->create('tenants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('director_id')->nullable()->index();

            $table->string('country_register', 14);
            $table->string('city_register', 10)->nullable();
            $table->string('state_register', 10)->nullable();
            $table->string('name');
            $table->string('label', 255)->nullable();
            $table->string('email')->index();
            $table->json('address')->nullable();
            $table->json('phones')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        TenantSeeder::start();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('tenants');
    }
}
