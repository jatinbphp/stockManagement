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
        Schema::create('stock_order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_order_id')->default(0);
            $table->string('status')->nullable();
            $table->text('notes_text')->nullable();
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_order_status_histories');
    }
};
