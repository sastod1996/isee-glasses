<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacksTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('packs', function (Blueprint $table) {
      $table->increments('id');
      $table->string('slug', 45)->unique();
      $table->string('name', 90);
      $table->string('name_en', 90)->nullable();
      $table->boolean('status')->default(true);
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
    Schema::dropIfExists('packs');
  }
}
