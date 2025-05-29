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
        Schema::create('item_stock_children', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('itemstock_master_id');
            $table->integer('receive_issue_child_id');
            $table->integer('store_id');
            $table->integer('opening_bal_qty');
            $table->double('opening_bal_rate', 20, 2);
            $table->double('opening_bal_amount', 20, 2);
            $table->integer('receive_qty');
            $table->double('receive_rate', 20, 2);
            $table->double('receive_amount', 20, 2);
            $table->string('issue_qty');
            $table->double('issue_rate', 20, 2);
            $table->double('issue_amount', 20, 2);
            $table->string('closing_bal_qty');
            $table->double('closing_bal_rate', 20, 2);
            $table->double('closing_bal_amount', 20, 2);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_stock_children');
    }
};
