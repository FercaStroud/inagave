<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('estate', 75);
            $table->string('price', 20);
            $table->string('quantity', 20);
            $table->string('total', 20);
            $table->string('preference_id', 200);
            $table->string('payment_id', 200);
            $table->string('merchant_order_id', 200);
            $table->string('payment_status', 200);

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
        Schema::dropIfExists('payments');
    }
}
