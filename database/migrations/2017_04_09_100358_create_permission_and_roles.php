<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionAndRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('admin_roles')) {
            Schema::create("admin_roles", function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('description');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('admin_permissions')) {
            Schema::create("admin_permissions", function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('description');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('admin_permission_role')) {
            Schema::create("admin_permission_role", function (Blueprint $table) {
                $table->increments('id');
                $table->integer("role_id");
                $table->integer("permission_id");
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('admin_role_user')) {
            Schema::create("admin_role_user", function (Blueprint $table) {
                $table->increments('id');
                $table->integer("role_id");
                $table->integer("user_id");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('admin_roles')) {
            Schema::drop('admin_roles');
        }
        if (Schema::hasTable('admin_permissions')) {
            Schema::drop('admin_permissions');
        }
        if (Schema::hasTable('admin_permission_role')) {
            Schema::drop('admin_permission_role');
        }
        if (Schema::hasTable('admin_role_user')) {
            Schema::drop('admin_role_user');
        }
    }
}
