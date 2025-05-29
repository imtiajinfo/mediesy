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
        Schema::table('purchase_orders_children', function (Blueprint $table) {
            $table->decimal('whole_sale_price', 20)->default(0)->after('sell_price');
            $table->integer('whole_sale_qty')->default(0)->after('whole_sale_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders_children', function (Blueprint $table) {
            //
        });
    }
};
