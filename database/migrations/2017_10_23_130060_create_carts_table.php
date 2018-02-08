<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('reference');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('status')->nullable();

            $table->integer('cost')->nullable();
            $table->integer('comission')->nullable();
            $table->integer('fee')->nullable();
            $table->integer('profit')->nullable();
            $table->integer('subtotal')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('total')->nullable();

            $table->integer('currency_code')->nullable();

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
        Schema::dropIfExists('carts');
    }
}
