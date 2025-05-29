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
        Schema::table('payment_to_suppliers', function (Blueprint $table) {
            $table->foreign(['spo_id'])->references(['id'])->on('purchase_orders')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['supplier_id'])->references(['id'])->on('suppliers')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_to_suppliers', function (Blueprint $table) {
            $table->dropForeign('payment_to_suppliers_spo_id_foreign');
            $table->dropForeign('payment_to_suppliers_supplier_id_foreign');
        });
    }
};
