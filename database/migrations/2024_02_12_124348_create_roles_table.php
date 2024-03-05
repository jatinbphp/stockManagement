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
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'id' => '1',
            'name' => 'Super Admin',
            'alias' => 'super_admin',
            'access_rights' => '["roles","users","suppliers","brands","practices","stock-orders","stock-orders-add","stock-orders-edit","stock-orders-delete","stock-orders-view","stock-orders-receive","stock-orders-stock-displayed","reports"]',
            'sort_order' => 1,
        ]);

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'id' => '2',
            'name' => 'Receiving Admin',
            'alias' => 'admin',
            'access_rights' => '["suppliers","brands","practices","stock-orders","stock-orders-edit","stock-orders-delete","stock-orders-view","stock-orders-receive","reports"]',
            'sort_order' => 2,
        ]);

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'id' => '3',
            'name' => 'Stock Clerk',
            'alias' => 'stock_clerk',
            'access_rights' => '["stock-orders"]',
            'sort_order' => 4,
        ]);

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'id' => '4',
            'name' => 'Accountant',
            'alias' => 'accountant',
            'access_rights' => '["stock-orders","stock-orders-view"]',
            'sort_order' => 5,
        ]);

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'id' => '5',
            'name' => 'General Admin',
            'alias' => 'general_admin',
            'access_rights' => '["stock-orders","stock-orders-view"]',
            'sort_order' => 3,
        ]);

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'id' => '6',
            'name' => 'Shop Manager',
            'alias' => 'shop_manager',
            'access_rights' => '["practices", "stock-orders","stock-orders-displayed"]',
            'sort_order' => 6,
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
