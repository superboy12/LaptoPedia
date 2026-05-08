<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('status');
            $table->string('courier_name')->nullable()->after('tracking_number');
            $table->timestamp('shipped_at')->nullable()->after('courier_name');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
        });
    }
    
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['tracking_number', 'courier_name', 'shipped_at', 'delivered_at']);
        });
    }
};