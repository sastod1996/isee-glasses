<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('rates', function (Blueprint $table) {
      $table->increments('id');
      $table->string('slug');
      $table->string('currency')->nullable();
      $table->decimal('value', 10, 2)->default(1);
      $table->string('symbol');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('rates');
  }
}
