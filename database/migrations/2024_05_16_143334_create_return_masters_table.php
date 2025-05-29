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
        Schema::create('return_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment('1=purchase,2=sales');
            $table->integer('master_id');
            $table->integer('cus_sup_id')->default(0);
            $table->integer('user_id');
            $table->string('invoice_no');
            $table->integer('ression_type');
            $table->decimal('return_amount', 20);
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_masters');
    }
};
