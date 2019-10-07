<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInteresadosTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('interesados', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 150);
      $table->string('email', 50)->unique();
      $table->string('telephone', 20);
      $table->integer('popup_id')->unsigned();
      $table->timestamps();

      $table->foreign('popup_id')->references('id')->on('popups');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('interesados');
  }
}
