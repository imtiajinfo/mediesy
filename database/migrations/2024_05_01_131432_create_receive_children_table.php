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
        Schema::create('receive_children', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('receive_master_id');
            $table->string('item_info_id');
            $table->string('uom_id');
            $table->string('payment_method_id');
            $table->string('item_cat_id')->nullable();
            $table->string('recv_quantity');
            $table->string('itm_receive_rate');
            $table->string('item_value_trans_curr');
            $table->string('item_value_local_curr');
            $table->string('fixed_rate')->nullable();
            $table->string('total_amt_trans_curr');
            $table->string('total_amt_local_curr');
            $table->string('gate_entry_at')->nullable();
            $table->string('gate_entry_by')->nullable();
            $table->string('opening_stock_remarks')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receive_children');
    }
};
