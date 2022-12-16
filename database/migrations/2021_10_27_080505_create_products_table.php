<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references("id")->on('categories');
            $table->text('name');
            $table->text('short_description');
            $table->text('description');
            $table->float('price');
            $table->integer('rate')->default(0);
            $table->float('total_discounts')->default(0);
            $table->integer('stock');
            $table->boolean('featured')->default(0);
            $table->boolean('active')->default(1);
            $table->softDeletesTz();
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
        Schema::dropIfExists('products');
    }
}
