<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_tag', function (Blueprint $table) {
           $table->unsignedBigInteger('product_id');
           $table->unsignedBigInteger('tag_id');
           $table->primary(['product_id','tag_id']);
           $table->foreign('product_id')->on('products')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
           $table->foreign('tag_id')->on('tags')->references('id')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_tag');
    }
}
