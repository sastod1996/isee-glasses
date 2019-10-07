<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAditcolorsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('aditcolors', function (Blueprint $table) {
      $table->increments('id');
      $table->string('slug', 45)->unique();
      $table->string('name', 90);
      $table->string('name_en', 90)->nullable();
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
    Schema::dropIfExists('aditcolors');
  }
}
