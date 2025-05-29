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
        Schema::create('purchase_orders_children', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('po_id');
            $table->integer('product_id');
            $table->integer('purchase_qty');
            $table->double('purchase_price', 20, 2);
            $table->float('sell_price', 10);
            $table->double('total_amount', 20, 2);
            $table->boolean('is_received')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders_children');
    }
};
