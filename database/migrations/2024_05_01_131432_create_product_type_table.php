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
        Schema::create('product_type', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('prod_cat_id')->nullable();
            $table->string('prod_type_name', 100)->unique();
            $table->string('prod_type_name_bn', 100);
            $table->double('sequence', 8, 2);
            $table->unsignedTinyInteger('is_active')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_type');
    }
};
