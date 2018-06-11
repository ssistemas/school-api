<?php

namespace Emtudo\Domains\Users\Database\Migrations;

use Emtudo\Domains\Users\Database\Seeders\UserSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    /**
     * Migration constructor.
     */
    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent1_id')->nullable()->index();
            $table->unsignedBigInteger('parent2_id')->nullable()->index();
            $table->unsignedBigInteger('responsible1_id')->nullable()->index();
            $table->unsignedBigInteger('responsible2_id')->nullable()->index();
            $table->unsignedBigInteger('married_id')->nullable()->index();

            $table->string('name', 50)->index();
            $table->string('email')->unique()->nullable();
            $table->string('country_register', 11)->nullable()->unique();
            $table->string('avatar_exten', 4)->nullable();

            $table->string('state_register', 14)->nullable();
            $table->char('state_register_state', 2)->nullable();
            $table->string('state_register_entity', 4)->nullable();

            $table->string('password');
            $table->enum('sex', ['male', 'female'])->nullable();

            $table->date('birthdate')->index();

            $table->json('address')->nullable();
            $table->json('phones')->nullable();

            $table->boolean('family_bag')->default(false);
            $table->unsignedInteger('natural_from')->nullable()->index();
            $table->string('profession')->nullable();
            $table->enum('marital_status', ['married', 'single', 'widower', 'divorced'])->nullable()->index();

            $table->boolean('is_admin')->default(false);
            $table->boolean('master')->default(false);

            $table->unsignedInteger('last_tenant')->nullable();

            $table->json('documents')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        UserSeeder::start();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('users');
    }
}
