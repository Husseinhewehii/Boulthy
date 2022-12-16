<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_promo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references("id")->on('orders');
            $table->foreignId('promo_id')->references("id")->on('promos');
            $table->unique(["order_id", "promo_id"]);
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
        Schema::dropIfExists('order_promo');
    }
}
