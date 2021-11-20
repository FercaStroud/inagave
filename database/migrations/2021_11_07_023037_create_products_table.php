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
            $table->bigIncrements('id');
            $table->string('estate', 75)->nullable();
            $table->string('size', 20)->nullable();
            $table->smallInteger('age')->nullable();
            $table->string('municipality', 75)->nullable();
            $table->string('location', 125)->nullable();
            $table->text('description')->nullable();
            $table->string('location_url', 475)->nullable();
            $table->integer('quantity');
            $table->float('price');
            $table->boolean('available')->default(1);
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
