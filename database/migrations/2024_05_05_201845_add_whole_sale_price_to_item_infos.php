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
            $table->decimal('whole_sale_price', 20)->default(0)->after('sell_price');
            $table->decimal('whole_sale_qty', 20)->default(0)->after('whole_sale_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_infos', function (Blueprint $table) {
            //
        });
    }
};
