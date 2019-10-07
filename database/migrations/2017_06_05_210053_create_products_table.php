<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->increments('id');
      $table->string('code', 45)->unique();
      $table->string('slug', 45)->nullable();
      $table->string('name', 90);
      $table->string('name_en', 90)->nullable();
      $table->text('description')->nullable();
      $table->text('description_en')->nullable();
      $table->integer('qty')->nullable();
      $table->integer('status')->default(1);
      $table->integer('color_sizes_status')->default(0);
      $table->string('image', 200)->nullable();
      $table->decimal('price', 10, 2)->nullable();
      $table->decimal('promo', 10, 2)->nullable();
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
    Schema::dropIfExists('products');
  }
}
