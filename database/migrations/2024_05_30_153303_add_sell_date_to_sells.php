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
        Schema::table('sells', function (Blueprint $table) {
            $table->dateTime('sell_date')->after('customer_id')->nullable();
        });
        $data = DB::table('sells')->get();
        foreach ($data as $key => $value) {
            DB::table('sells')->where('id', $value->id)->update(['sell_date'=>$value->created_at]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sells', function (Blueprint $table) {
            $table->dropColumn('sell_date');
        });
    }
};
