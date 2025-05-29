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
        Schema::create('categories', function (Blueprint $table) {
            $table->comment('Parent_id categories table id');
            $table->bigIncrements('id');
            $table->string('name_english');
            $table->string('name_bangla')->nullable();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->text('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('descriptions')->nullable();
            $table->boolean('home_status')->default(true);
            $table->string('logo')->default('category.png');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
