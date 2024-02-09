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
        Schema::create('products_options_values', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->default(0);
            $table->integer('option_id')->default(0);
            $table->string('option_value')->default(0);
            $table->string('option_price')->default(0);
            $table->string('status')->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_options_values');
    }
};
