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
            $table->increments('user_id');
            $table->string('first_name')->default('');
            $table->string('second_name')->default('');
            $table->string('third_name')->default('');
            $table->string('email')->unique();
            $table->string('login')->unique();
            $table->string('password');
            $table->enum('role',['admin','author','subscriber'] )->default('author');
            $table->string('user_thumbnail')
                ->default('');

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
        Schema::dropIfExists('users');
    }
}
