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
        Schema::table('sells_items', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('item_infos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['sell_id'])->references(['id'])->on('sells')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sells_items', function (Blueprint $table) {
            $table->dropForeign('sells_items_product_id_foreign');
            $table->dropForeign('sells_items_sell_id_foreign');
        });
    }
};
