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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id');
            $table->integer('supplier_id');
            $table->integer('total_purchase_qty');
            $table->integer('total_received_qty');
            $table->double('total_purchase_amount', 20, 2);
            $table->double('purchase_price', 20, 2)->nullable();
            $table->dateTime('po_date')->useCurrent();
            $table->boolean('is_purchased')->default(false);
            $table->boolean('is_received')->default(false);
            $table->boolean('is_closed')->default(false);
            $table->integer('purchased_by');
            $table->text('remarks');
            $table->string('challan_attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
