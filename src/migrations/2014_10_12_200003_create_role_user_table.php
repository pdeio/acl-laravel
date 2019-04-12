<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for associating roles to users (Many-to-Many)
        Schema::create(config('entrust.role_user_table', 'role_user'), function (Blueprint $table) {

            $role_foreign_key = config('entrust.role_foreign_key', 'role_id');
            $user_foreign_key = config('entrust.user_foreign_key', 'user_id');
            $users_table = config('entrust.users_table', 'users');
            $roles_table = config('entrust.roles_table', 'roles');

            if (config('database.default') == 'mysql') {
                $table->engine = config('entrust.mysql_engine', 'InnoDB');
            }

            $table->bigInteger($user_foreign_key)->unsigned();
            $table->bigInteger($role_foreign_key)->unsigned();

            $table->foreign($user_foreign_key)->references('id')->on($users_table)
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign($role_foreign_key)->references('id')->on($roles_table)
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop(config('entrust.role_user_table', 'role_user'));
    }
}
