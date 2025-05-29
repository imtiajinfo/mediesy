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
        Schema::create('money_lendings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_bangla');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->integer('nid');
            $table->string('country');
            $table->string('division');
            $table->string('district');
            $table->string('city');
            $table->string('Area');
            $table->string('postcode');
            $table->string('parent_address');
            $table->string('permanent_address');
            $table->date('from_date');
            $table->date('to_date');
            $table->double('to_amount', 20, 2);
            $table->double('recv_amount', 20, 2)->nullable();
            $table->double('due_amount', 20, 2)->nullable();
            $table->double('monthly_profit', 20, 2)->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('money_lendings');
    }
};
