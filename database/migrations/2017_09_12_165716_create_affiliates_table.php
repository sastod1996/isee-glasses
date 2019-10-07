<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliatesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('affiliates', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('client_id')->unsigned();
      $table->timestamps();

      $table->foreign('client_id')->references('user_id')->on('clients');

    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('affiliates');
  }
}
