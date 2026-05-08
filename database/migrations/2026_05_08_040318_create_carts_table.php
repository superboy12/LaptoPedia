<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id('id_cart');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 0);
            $table->timestamps();
            
            // HAPUS foreign key dulu - COMMENT INI
            // $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            // $table->foreign('product_id')->references('id_product')->on('products')->onDelete('cascade');
            
            $table->unique(['user_id', 'product_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};