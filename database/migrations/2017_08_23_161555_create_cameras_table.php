<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCamerasTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('cameras', function (Blueprint $table) {
      $table->increments('id');
      $table->string('url', 120)->nullable();
      $table->integer('attribute_product_id')->unsigned();
      $table->timestamps();

      $table->foreign('attribute_product_id')->references('id')->on('attribute_product')->onDelete('cascade');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('cameras');
  }
}
