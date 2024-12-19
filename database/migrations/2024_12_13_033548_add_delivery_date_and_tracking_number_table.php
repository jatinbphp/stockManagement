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
        Schema::table('stock_orders', function (Blueprint $table) {
            $table->integer('is_delivered')->default(0)->after('status');
            $table->datetime('order_delivey_date')->nullable()->after('is_delivered');
            $table->string('courier_tracking_number')->nullable()->after('order_delivey_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_orders', function (Blueprint $table) {
            $table->dropColumn('is_delivered');
            $table->dropColumn('order_delivey_date');
            $table->dropColumn('courier_tracking_number');
        });
    }
};
