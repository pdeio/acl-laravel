<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create(config('entrust.permission_role_table', 'permission_role'), function (Blueprint $table) {
            
            $permission_foreign_key = config('entrust.permission_foreign_key', 'permission_id');
            $role_foreign_key = config('entrust.role_foreign_key', 'role_id');
            $permissions_table = config('entrust.permissions_table', 'permissions');
            $roles_table = config('entrust.roles_table', 'roles');

            if (config('database.default') == 'mysql'){ $table->engine = config('entrust.mysql_engine', 'InnoDB');}

            $table->bigInteger($role_foreign_key)->unsigned();
            $table->bigInteger($permission_foreign_key)->unsigned();

            $table->foreign($role_foreign_key)->references('id')->on($roles_table)
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign($permission_foreign_key)->references('id')->on($permissions_table)
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary([$role_foreign_key, $permission_foreign_key]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop(config('entrust.permission_role_table', 'permission_role'));
    }
}
