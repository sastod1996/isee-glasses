<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('options', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 90);
      $table->string('name_en', 90)->nullable();
      $table->text('description')->nullable();
      $table->text('description_en')->nullable();
      $table->string('image', 200)->nullable();
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
    Schema::dropIfExists('options');
  }
}
