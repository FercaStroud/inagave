<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('price', 20);
            $table->string('quantity', 20);
            $table->string('total', 20);
            $table->string('collection_id', 200)->nullable();
            $table->string('collection_status', 200)->nullable();
            $table->string('payment_id', 200)->nullable();
            $table->string('status', 200)->nullable();
            $table->string('payment_type', 200)->nullable();
            $table->string('external_reference', 200)->nullable();
            $table->string('merchant_order_id', 200)->nullable();
            $table->string('preference_id', 200)->nullable();
            $table->string('site_id', 200)->nullable();
            $table->string('processing_mode', 200)->nullable();
            $table->string('merchant_account_id', 200)->nullable();
            $table->boolean('feedback_status')->default(false);
            $table->boolean('preference_status')->default(false);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();;

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
        Schema::dropIfExists('maintenances');
    }
}
