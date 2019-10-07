<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponAttributeTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('coupon_attribute', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('coupon_id')->unsigned(); //null si es de sistema
      $table->integer('attribute_id')->unsigned(); //null si es de sistema
      $table->timestamps();

      $table->foreign('coupon_id')->references('id')->on('coupons');
      $table->foreign('attribute_id')->references('id')->on('attributes');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('coupon_attribute');
  }
}
