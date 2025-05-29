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
        Schema::create('receive_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('issue_master_id')->nullable();
            $table->integer('spo_id')->nullable();
            $table->integer('tran_type_id');
            $table->integer('tran_source_type_id');
            $table->integer('prod_type_id');
            $table->integer('company_id');
            $table->integer('branch_id');
            $table->integer('store_id');
            $table->integer('currency_id');
            $table->double('excg_rate', 22, 2);
            $table->integer('supplier_id')->nullable();
            $table->dateTime('receive_date');
            $table->string('grn_number')->nullable();
            $table->dateTime('grn_date')->nullable();
            $table->integer('chalan_number')->nullable();
            $table->dateTime('chalan_date')->nullable();
            $table->double('total_amt_trans_curr', 22, 2);
            $table->double('total_amt_local_curr', 22, 2);
            $table->boolean('is_paid')->default(false);
            $table->string('remarks')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receive_masters');
    }
};
