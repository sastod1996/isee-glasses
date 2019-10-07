<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponeables extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('couponeables', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('coupon_id')->unsigned();
      $table->integer('couponeable_id')->unsigned();
      $table->string('couponeable_type');

      $table->timestamps();

      $table->foreign('coupon_id')->references('id')->on('coupons');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('couponeables');
  }
}
