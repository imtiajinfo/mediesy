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
        Schema::create('item_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_type', 50);
            $table->string('name', 250);
            $table->string('name_bangla', 250)->nullable();
            $table->string('slug');
            $table->string('code')->nullable();
            $table->unsignedBigInteger('category_id')->index('item_infos_category_id_foreign');
            $table->unsignedBigInteger('brand_id')->nullable()->index('item_infos_brand_id_foreign');
            $table->string('brand')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('strength')->nullable();
            $table->longText('description')->nullable();
            $table->string('use_for')->nullable();
            $table->string('dar')->nullable();
            $table->json('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable()->index('item_infos_size_id_foreign');
            $table->string('weight', 80)->nullable()->default('0');
            $table->decimal('published_price', 10)->nullable();
            $table->decimal('purchase_price', 10)->nullable();
            $table->decimal('sell_price', 10)->nullable();
            $table->string('min_qty', 80)->nullable();
            $table->string('trans_uom', 80)->nullable();
            $table->string('stock_uom', 80)->nullable();
            $table->string('sales_uom', 80)->nullable();
            $table->integer('discount_type')->nullable();
            $table->decimal('discount_amount', 10)->default(0);
            $table->tinyInteger('tax')->nullable();
            $table->decimal('tax_amount', 20)->nullable();
            $table->integer('current_stock')->default(0);
            $table->integer('reorder_level')->default(1);
            $table->integer('safety_level')->default(1);
            $table->string('thumbnail')->default('default.png');
            $table->json('attachment')->nullable();
            $table->integer('stock_status')->default(0);
            $table->boolean('approved_status')->default(true);
            $table->boolean('is_published')->default(false);
            $table->boolean('status')->default(true);
            $table->string('sub_title', 200)->nullable();
            $table->text('summary')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_infos');
    }
};
