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
        Schema::create('payment_to_suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_id')->index('payment_to_suppliers_supplier_id_foreign');
            $table->unsignedBigInteger('spo_id')->index('payment_to_suppliers_spo_id_foreign');
            $table->double('payable_amount', null, 0);
            $table->double('due_amount', null, 0)->nullable();
            $table->double('paid_amount', null, 0)->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_to_suppliers');
    }
};
