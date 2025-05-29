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
        Schema::table('item_store_mappings', function (Blueprint $table) {
            $table->foreign(['item_id'])->references(['id'])->on('item_infos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['store_id'])->references(['id'])->on('stores')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_store_mappings', function (Blueprint $table) {
            $table->dropForeign('item_store_mappings_item_id_foreign');
            $table->dropForeign('item_store_mappings_store_id_foreign');
        });
    }
};
