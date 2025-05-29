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
        Schema::table('item_stock_masters', function (Blueprint $table) {
            $table->integer('stock_in')->default(0)->after('receive_Issue_master_id');
            $table->integer('stock_out')->default(0)->after('stock_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_stock_masters', function (Blueprint $table) {
            //
        });
    }
};
