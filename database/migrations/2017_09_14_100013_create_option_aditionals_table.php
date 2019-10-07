<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionAditionalsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('option_aditionals', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('aditional_id')->unsigned();
      $table->integer('option_id')->unsigned();
      $table->integer('type_pack_id')->unsigned();
      $table->decimal('price', 10, 2)->nullable();
      $table->timestamps();

      $table->foreign('aditional_id')->references('id')->on('aditionals');
      $table->foreign('option_id')->references('id')->on('options');
      $table->foreign('type_pack_id')->references('id')->on('type_packs');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('option_aditionals');
  }
}
