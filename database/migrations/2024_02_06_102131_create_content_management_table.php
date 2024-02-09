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
        Schema::create('content_management', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('content_management')->insert([
            'id' => '1',
            'title' => 'Terms & Condition',
        ]);

        \Illuminate\Support\Facades\DB::table('content_management')->insert([
            'id' => '2',
            'title' => 'Privacy Policy',
        ]);

        \Illuminate\Support\Facades\DB::table('content_management')->insert([
            'id' => '3',
            'title' => 'About Us',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_management');
    }
};
