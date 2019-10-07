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
      $table->string('first_name', 45);
      $table->string('last_name', 45);
      $table->string('email', 45)->unique();
      $table->string('telephone', 9)->nullable();
      $table->string('password');
      $table->integer('role_id')->unsigned()->nullable();
      $table->integer('rate_id')->unsigned()->nullable();

      $table->rememberToken();
      $table->timestamps();

      $table->foreign('role_id')->references('id')->on('roles');
      $table->foreign('rate_id')->references('id')->on('rates');
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
