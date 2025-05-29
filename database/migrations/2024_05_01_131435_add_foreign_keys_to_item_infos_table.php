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
        Schema::table('item_infos', function (Blueprint $table) {
            $table->foreign(['brand_id'])->references(['id'])->on('brands')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['category_id'])->references(['id'])->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['size_id'])->references(['id'])->on('sizes')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_infos', function (Blueprint $table) {
            $table->dropForeign('item_infos_brand_id_foreign');
            $table->dropForeign('item_infos_category_id_foreign');
            $table->dropForeign('item_infos_size_id_foreign');
        });
    }
};
