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
        Schema::table('warranties', function (Blueprint $table) {
            $table->foreign(['customer_id'])->references(['id'])->on('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['item_id'])->references(['id'])->on('item_infos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['sells_id'])->references(['id'])->on('sells')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['store_id'])->references(['id'])->on('stores')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warranties', function (Blueprint $table) {
            $table->dropForeign('warranties_customer_id_foreign');
            $table->dropForeign('warranties_item_id_foreign');
            $table->dropForeign('warranties_sells_id_foreign');
            $table->dropForeign('warranties_store_id_foreign');
        });
    }
};
