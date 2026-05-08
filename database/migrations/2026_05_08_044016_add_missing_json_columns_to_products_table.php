<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Cek dan tambah kolom yang belum ada
            if (!Schema::hasColumn('products', 'highlights')) {
                $table->json('highlights')->nullable()->after('description');
            }
            
            if (!Schema::hasColumn('products', 'variations')) {
                $table->json('variations')->nullable()->after('highlights');
            }
            
            // spec_title dan spec_description sudah ada, jadi skip
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'highlights')) {
                $table->dropColumn('highlights');
            }
            if (Schema::hasColumn('products', 'variations')) {
                $table->dropColumn('variations');
            }
        });
    }
};