<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('order_product', function (Blueprint $table) {
      $table->integer('order_id')->unsigned();
      $table->integer('product_id')->unsigned();
      $table->decimal('prod_price', 10, 2);
      $table->string('image', 200)->nullable();
      $table->string('code_color', 100)->nullable();
      $table->integer('color_id')->unsigned();
      $table->integer('color_attr')->unsigned();
      $table->integer('size_id')->unsigned();
      $table->integer('size_attr')->unsigned();
      $table->integer('type_id')->unsigned(); //no null!!
      $table->integer('pack_id')->unsigned(); //no null!!
      $table->decimal('pack_price', 10, 2);
      $table->integer('opt_id')->unsigned()->nullable();
      $table->integer('optcolor_id')->unsigned()->nullable();
      $table->decimal('opt_price', 10, 2)->nullable();
      $table->integer('prescription_id')->unsigned()->nullable(); //null si es sin medida
      $table->decimal('pres_esfod',5,2)->nullable()->default(0);
      $table->decimal('pres_esfoi',5,2)->nullable()->default(0);
      $table->decimal('pres_esfdip',5,2)->nullable()->default(0);
      $table->decimal('pres_dip',5,2)->nullable()->default(0);
      $table->decimal('pres_cilod',5,2)->nullable()->default(0);
      $table->decimal('pres_ciloi',5,2)->nullable()->default(0);
      $table->decimal('pres_axiod',5,2)->nullable()->default(0);
      $table->decimal('pres_axioi',5,2)->nullable()->default(0);
      $table->decimal('pres_addod',5,2)->nullable()->default(0);
      $table->decimal('pres_addoi',5,2)->nullable()->default(0);
      $table->integer('warranty_id')->unsigned()->nullable();
      $table->decimal('warranty_price', 10, 2)->nullable();
      $table->decimal('subtotalprice', 10, 2);
      $table->decimal('discount', 10, 2)->nullable();
      $table->decimal('comission', 10, 2)->nullable();
      $table->decimal('totalprice', 10, 2);

      $table->primary(['order_id', 'product_id']);

      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
      $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
      $table->foreign('color_id')->references('id')->on('attributes');
      $table->foreign('color_attr')->references('id')->on('attribute_product');
      $table->foreign('size_id')->references('id')->on('attributes');
      $table->foreign('size_attr')->references('id')->on('attribute_product');
      $table->foreign('type_id')->references('id')->on('types');
      $table->foreign('pack_id')->references('id')->on('packs');
      $table->foreign('opt_id')->references('id')->on('options');
      $table->foreign('optcolor_id')->references('id')->on('optadit_color');
      $table->foreign('warranty_id')->references('id')->on('warranties');
      $table->foreign('prescription_id')->references('id')->on('prescriptions');
      // $table->foreign('warranty_id')->references('id')->on('warranties');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('order_product');
  }
}
