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
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id')->default('1');
            $table->boolean('store_type')->default(false);
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('email')->unique();
            $table->unsignedBigInteger('country')->nullable()->index('stores_country_foreign');
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->string('postcode')->nullable();
            $table->string('address');
            $table->integer('nid')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
