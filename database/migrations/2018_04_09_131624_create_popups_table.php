<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePopupsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('popups', function (Blueprint $table) {
      $table->increments('id');
      $table->string('slug', 45)->unique();
      $table->string('name', 90);
      $table->string('title', 100)->nullable();
      $table->text('text_main')->nullable();
      $table->text('text_secondary')->nullable();
      $table->string('text_close', 100)->nullable();
      $table->integer('status')->default(1);
      $table->string('image', 200)->nullable();
      $table->date('end_date')->nullable();
      $table->text('message_presentation')->nullable();
      $table->text('message_coupon')->nullable();
      $table->integer('coupon_id')->unsigned();
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
    Schema::dropIfExists('popups');
  }
}
