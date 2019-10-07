<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStateTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('order_state', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('order_id')->unsigned();
      $table->integer('state_id')->unsigned();
      $table->boolean('active');
      $table->date('date');
      $table->timestamps();

      $table->foreign('order_id')->references('id')->on('orders');
      $table->foreign('state_id')->references('id')->on('states');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('order_state');
  }
}
