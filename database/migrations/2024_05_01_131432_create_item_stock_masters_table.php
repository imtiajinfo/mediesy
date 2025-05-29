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
        Schema::create('item_stock_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status');
            $table->unsignedBigInteger('receive_Issue_master_id');
            $table->integer('tran_type_id');
            $table->integer('tran_source_type_id');
            $table->integer('prod_type_id');
            $table->integer('company_id');
            $table->integer('branch_id');
            $table->integer('currency_id');
            $table->dateTime('receive_issue_date');
            $table->dateTime('opening_bal_date');
            $table->integer('supplier_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('uom_id');
            $table->string('issue_for');
            $table->string('prod_process');
            $table->integer('payment_method_id')->nullable();
            $table->integer('item_cat_id');
            $table->integer('challan_number')->nullable();
            $table->dateTime('challan_date')->nullable();
            $table->text('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_stock_masters');
    }
};
