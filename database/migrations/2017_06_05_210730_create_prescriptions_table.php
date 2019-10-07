<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('prescriptions', function (Blueprint $table) {
      $table->increments('id');
      $table->string('code', 45)->unique();
      $table->string('name', 120);
      $table->decimal('esfod',5,2)->default(0);
      $table->decimal('esfoi',5,2)->default(0);
      $table->integer('esfdip')->default(0);
      $table->integer('dip')->default(0);
      $table->decimal('cilod',5,2)->default(0);
      $table->decimal('ciloi',5,2)->default(0);
      $table->integer('axiod')->default(0);
      $table->integer('axioi')->default(0);
      $table->decimal('addod',5,2)->default(0);
      $table->decimal('addoi',5,2)->default(0);
      $table->text('description')->nullable();
      $table->string('file', 120)->nullable();
      $table->boolean('status')->nullable();
      $table->integer('client_id')->unsigned()->nullable();
      $table->timestamps();

      $table->foreign('client_id')->references('id')->on('clients');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('prescriptions');
  }
}
