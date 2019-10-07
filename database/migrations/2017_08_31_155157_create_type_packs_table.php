<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypePacksTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('type_packs', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('type_id')->unsigned();
      $table->integer('pack_id')->unsigned();
      $table->decimal('price', 10, 2)->nullable();
      $table->decimal('esfmin', 10, 2)->nullable();
      $table->decimal('esfmax', 10, 2)->nullable();
      $table->decimal('cilmin', 10, 2)->nullable();
      $table->decimal('cilmax', 10, 2)->nullable();
      $table->string('material', 90);
      $table->string('material_en', 90);
      $table->text('description')->nullable();
      $table->text('description_en')->nullable();
      $table->text('help')->nullable();
      $table->text('help_en')->nullable();
      $table->timestamps();

      $table->foreign('type_id')->references('id')->on('types');
      $table->foreign('pack_id')->references('id')->on('packs');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('type_packs');
  }
}
