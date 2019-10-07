<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('coupons', function (Blueprint $table) {
      $table->increments('id');
      $table->string('code', 45)->unique();
      $table->integer('affiliate_id')->unsigned()->nullable(); //null si es de sistema
      $table->boolean('status');
      $table->integer('percent');
      $table->decimal('limit', 10, 2)->nullable();
      $table->integer('percent_commission')->nullable();
      $table->decimal('max_commission', 10, 2)->nullable();
      $table->boolean('payment_status')->nullable();
      $table->date('start_date')->nullable();
      $table->date('end_date')->nullable();
      $table->integer('count')->default(0); //cuantas veces se uso el cupon
      // $table->integer('service_id')->unsigned()->nullable();
      $table->timestamps();

      // $table->foreign('affiliate_id')->references('id')->on('affiliate');

    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('coupons');
  }
}
