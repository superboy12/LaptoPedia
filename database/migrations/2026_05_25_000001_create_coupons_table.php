<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->enum('type', ['fixed', 'percent'])->default('fixed');
            $table->unsignedBigInteger('value')->default(0); // rupiah atau persen
            $table->unsignedBigInteger('min_purchase')->nullable();  // min. transaksi
            $table->unsignedBigInteger('max_discount')->nullable();  // maks. potongan (untuk persen)
            $table->date('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('usage_limit')->nullable();     // null = unlimited
            $table->unsignedInteger('used_count')->default(0);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
