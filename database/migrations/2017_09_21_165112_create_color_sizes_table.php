<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorSizesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('color_sizes', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('color_id')->unsigned();
      $table->integer('size_id')->unsigned();
      $table->integer('stock')->nullable();
      $table->timestamps();

      $table->foreign('color_id')->references('id')->on('attribute_product')->onDelete('cascade');
      $table->foreign('size_id')->references('id')->on('attribute_product')->onDelete('cascade');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('color_sizes');
  }
}
