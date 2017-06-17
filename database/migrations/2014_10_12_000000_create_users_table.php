<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('password')->default(null);
            $table->string('avatar')->nullable();
            $table->string('social_network')->nullable();
            $table->string('social_id')->nullable();
            $table->tinyInteger('ban')->default(0);
            $table->enum('type', ['user', 'admin', 'editor'])->default('user');
            $table->text('user_descr')->nullable();
            $table->text('editor_descr')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
