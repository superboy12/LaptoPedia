<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Cek apakah kolom cart_data sudah ada
            if (!Schema::hasColumn('orders', 'cart_data')) {
                $table->json('cart_data')->nullable();
            }
        });
    }
    
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'cart_data')) {
                $table->dropColumn('cart_data');
            }
        });
    }
};