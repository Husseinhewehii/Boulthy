<?php

use App\Constants\Payment_Methods;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->foreignId('user_id')->references("id")->on('users');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->integer('status');
            $table->float('total')->default(0);
            $table->float('total_promos')->default(0);
            $table->float('sub_total')->default(0);
            $table->float('final_total')->default(0);
            $table->string('address');
            $table->text('note')->nullable();
            $table->integer('payment_method')->default(Payment_Methods::CARD_PAYMENT);
            $table->float('fees')->default(0);
            $table->foreignId('city_id')->default(0);
            $table->float('city_price')->default(0);
            $table->foreignId('district_id')->default(0);
            $table->float('district_price')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
