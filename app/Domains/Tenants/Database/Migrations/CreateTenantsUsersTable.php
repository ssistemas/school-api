<?php

namespace Emtudo\Domains\Tenants\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTenantsUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->schema->create('tenants_users', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->boolean('student')->default(false);
            $table->boolean('responsible')->default(false);
            $table->boolean('teacher')->default(false);
            $table->boolean('manager')->default(false);
            $table->timestamps();

            $table->unique(['tenant_id', 'user_id']);
            $table->unique(['tenant_id', 'user_id', 'student']);
            $table->unique(['tenant_id', 'user_id', 'responsible']);
            $table->unique(['tenant_id', 'user_id', 'teacher']);
            $table->unique(['tenant_id', 'user_id', 'manager']);

            $table->index(['user_id', 'student']);
            $table->index(['user_id', 'responsible']);
            $table->index(['user_id', 'teacher']);
            $table->index(['user_id', 'manager']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('tenants_users');
    }
}
