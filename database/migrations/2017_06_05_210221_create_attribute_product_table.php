<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeProductTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('attribute_product', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('product_id')->unsigned();
      $table->integer('attribute_id')->unsigned();
      $table->integer('status')->default(1);
      $table->string('lab_codecolor', 45)->nullable();
      $table->integer('bridge')->nullable();
      $table->integer('width')->nullable();
      $table->integer('height')->nullable();
      $table->integer('large')->nullable();
      $table->timestamps();

      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
      $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('attribute_product');
  }
}
