<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('attributes', function (Blueprint $table) {
      $table->increments('id');
      $table->string('slug', 45)->nullable();
      $table->string('name', 45)->unique();
      $table->string('name_en', 45)->nullable();
      $table->integer('status')->default(1);
      $table->string('primary', 45)->nullable();
      $table->integer('view')->default(1);
      $table->integer('premium')->default(0);
      $table->integer('characteristic_id')->unsigned();
      $table->timestamps();

      $table->foreign('characteristic_id')->references('id')->on('characteristics');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('attributes');
  }
}
