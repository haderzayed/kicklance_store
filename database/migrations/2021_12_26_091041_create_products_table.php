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
            $table->string('name');
            $table->unsignedBigInteger('category__id');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->float('price')->unsigned();
            $table->float('sale_price')->unsigned()->nullable();
            $table->unsignedBigInteger('quantity')->default(0);
            $table->foreign('category__id')->on('categories')->references('id')
                  ->cascadeOnDelete()->cascadeOnDelete();
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
