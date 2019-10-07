<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('sliders', function (Blueprint $table) {
      $table->increments('id');
      $table->string('image', 200)->nullable();
      $table->integer('buttons')->default(0);
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
    Schema::dropIfExists('sliders');
  }
}
