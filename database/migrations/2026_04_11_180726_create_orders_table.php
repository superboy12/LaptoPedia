<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->string('order_number')->unique(); 
            $table->integer('total_price');
            $table->enum('status', ['pending', 'paid', 'shipped', 'completed'])->default('pending');
            $table->string('snap_token')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};