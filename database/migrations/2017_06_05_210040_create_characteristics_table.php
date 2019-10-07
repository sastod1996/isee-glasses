<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacteristicsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('characteristics', function (Blueprint $table) {
      $table->increments('id');
      $table->string('slug', 45);
      $table->string('name', 45);
      $table->string('name_en', 45)->nullable();
      $table->integer('order')->nullable();
      $table->integer('multiple')->default(0);
      $table->integer('deep')->default(1);
      $table->integer('view')->default(1);
      $table->integer('status')->default(1);
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
    Schema::dropIfExists('characteristics');
  }
}
