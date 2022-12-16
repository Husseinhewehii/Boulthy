<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references("id")->on('users');
            $table->text('name');
            $table->text('short_description');
            $table->text('description');
            $table->string('code', 6)->unique();
            $table->float('percentage');
            $table->boolean('active')->default(1);
            $table->integer('type');
            $table->dateTimetz('start_date');
            $table->dateTimetz('end_date');
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
        Schema::dropIfExists('promos');
    }
}
