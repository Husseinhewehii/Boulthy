<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references("id")->on('users');
            $table->foreignId('promo_id')->references("id")->on('promos');
            $table->unique(["user_id", "promo_id"]);
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
        Schema::dropIfExists('promo_user');
    }
}
