<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptaditColorTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('optadit_color', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('option_aditional_id')->unsigned();
      $table->integer('aditcolor_id')->unsigned();
      $table->timestamps();

      $table->foreign('option_aditional_id')->references('id')->on('option_aditionals');
      $table->foreign('aditcolor_id')->references('id')->on('aditcolors');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('optadit_color');
  }
}
