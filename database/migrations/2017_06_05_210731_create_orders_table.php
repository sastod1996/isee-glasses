<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->increments('id');
      $table->string('nro', 45)->nullable(); //numero de pedido
      $table->string('code', 45)->nullable(); //codigo de trackeo
      //tipo de pago
      $table->integer('client_id')->unsigned();
      $table->date('date_order');
      $table->string('country', 30)->nullable();
      $table->string('city', 30)->nullable();
      $table->string('district', 30)->nullable();
      $table->string('address', 100)->nullable();
      $table->string('postal_code', 10)->nullable();
      $table->string('reference', 100)->nullable();
      $table->integer('rate_id')->unsigned();
      $table->decimal('subtotal', 10, 2)->nullable();
      $table->decimal('igv', 10, 2)->nullable();
      $table->integer('coupon_id')->unsigned()->nullable();
      $table->decimal('discount', 10, 2)->nullable();
      $table->decimal('comission', 10, 2)->nullable();
      $table->decimal('price', 10, 2);
      $table->timestamps();

      $table->foreign('client_id')->references('user_id')->on('clients');
      $table->foreign('coupon_id')->references('id')->on('coupons');
      $table->foreign('rate_id')->references('id')->on('rates');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('orders');
  }
}
