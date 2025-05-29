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
        Schema::create('uoms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('uom_set_id');
            $table->string('uom_short_code');
            $table->string('uom_desc');
            $table->integer('relative_factor');
            $table->integer('fraction_allow');
            $table->tinyInteger('is_active')->default(0);
            $table->string('local_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uoms');
    }
};
