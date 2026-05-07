<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('spec_title')->nullable()->after('description');
            $table->text('spec_description')->nullable()->after('spec_title');
        });

        Schema::create('product_highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('label'); // e.g., "PROCESSOR"
            $table->string('title'); // e.g., "Pro-Class"
            $table->string('description')->nullable(); // e.g., "Prosesor generasi terbaru terintegrasi."
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_highlights');
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['spec_title', 'spec_description']);
        });
    }
};
