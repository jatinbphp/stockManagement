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
        Schema::create('stock_order_receives', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_order_id')->default(0);
            $table->text('grv_number')->nullable();
            $table->text('inv_number')->nullable();
            $table->longText('notes')->nullable();
            $table->integer('stock_order_status')->default(0);
            $table->integer('added_by')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_order_receives');
    }
};