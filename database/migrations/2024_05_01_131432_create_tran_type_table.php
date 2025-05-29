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
        Schema::create('tran_type', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('tran_source_type_id');
            $table->string('tran_type_name', 100);
            $table->string('tran_type_name_bn', 100);
            $table->double('sequence_number', 8, 2);
            $table->unsignedTinyInteger('is_active')->default(0);
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tran_type');
    }
};
