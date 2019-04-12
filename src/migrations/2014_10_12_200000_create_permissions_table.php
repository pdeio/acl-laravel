<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing permissions
        Schema::create(config('entrust.permissions_table', 'permissions'), function (Blueprint $table) {
            if (config('database.default') == 'mysql'){ $table->engine = config('entrust.mysql_engine', 'InnoDB');}
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop(config('entrust.permissions_table', 'permissions'));
    }
}
