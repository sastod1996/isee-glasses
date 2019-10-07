<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarrantiesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('warranties', function (Blueprint $table) {
      $table->increments('id');
      $table->string('slug', 45)->unique();
      $table->string('name', 90);
      $table->string('name_en', 90)->nullable();
      $table->text('description')->nullable();
      $table->text('description_en')->nullable();
      $table->decimal('price', 10, 2)->default(0);
      $table->integer('time')->nullable();
      $table->string('period', 10)->nullable();
      $table->string('period_en', 10)->nullable();
      $table->text('help')->nullable();
      $table->text('help_en')->nullable();
      $table->integer('view')->default(1);
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
    Schema::dropIfExists('warranties');
  }
}
