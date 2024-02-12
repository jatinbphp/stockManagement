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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('alias')->nullable();
            $table->text('access_rights')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'id' => '1',
            'name' => 'Admin',
            'alias' => 'admin',
        ]);

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'id' => '2',
            'name' => 'Stock Clerk',
            'alias' => 'stock_clerk',
        ]);

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'id' => '3',
            'name' => 'Accountant',
            'alias' => 'accountant',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
