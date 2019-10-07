<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('clients', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->string('country', 30)->nullable();
      $table->string('city', 30)->nullable();
      $table->string('code', 10)->nullable();
      $table->string('district', 30)->nullable();
      $table->string('address', 100)->nullable();
      $table->string('reference', 100)->nullable();
      $table->integer('status_affiliate')->nullable();
      $table->integer('dni')->unsigned()->nullable();
      $table->string('facebook',100)->nullable();
      $table->string('instagram',100)->nullable();
      $table->string('twitter',100)->nullable();
      $table->string('youtube',100)->nullable();
      // $table->boolean('ally')->default(0);
      // $table->integer('enterprise_id')->unsigned()->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users');
      // $table->foreign('enterprise_id')->references('id')->on('enterprises');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('clients');
  }
}
