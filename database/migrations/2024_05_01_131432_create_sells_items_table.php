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
        Schema::create('sells_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id')->nullable();
            $table->unsignedBigInteger('sell_id')->index('sells_items_sell_id_foreign');
            $table->unsignedBigInteger('product_id')->index('sells_items_product_id_foreign');
            $table->string('bar_code')->nullable();
            $table->string('qr_code')->nullable();
            $table->double('discount_amount', null, 0)->nullable();
            $table->double('published_price', null, 0);
            $table->double('sell_price', 20, 2)->nullable();
            $table->double('tax', 20, 2)->default(0);
            $table->double('sub_total', null, 0)->nullable();
            $table->double('shipping_cost', 20, 2)->default(0);
            $table->integer('quantity')->nullable();
            $table->string('payment_status', 10)->default('unpaid');
            $table->string('delivery_status', 20)->nullable()->default('pending');
            $table->string('shipping_type')->nullable();
            $table->string('product_referral_code')->nullable();
            $table->integer('sells_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sells_items');
    }
};
