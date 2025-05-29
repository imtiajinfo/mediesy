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
        Schema::create('warranties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id')->index('warranties_store_id_foreign');
            $table->unsignedBigInteger('customer_id')->index('warranties_customer_id_foreign');
            $table->unsignedBigInteger('sells_id')->index('warranties_sells_id_foreign');
            $table->unsignedBigInteger('item_id')->index('warranties_item_id_foreign');
            $table->string('type');
            $table->string('duration');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('notes')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranties');
    }
};
