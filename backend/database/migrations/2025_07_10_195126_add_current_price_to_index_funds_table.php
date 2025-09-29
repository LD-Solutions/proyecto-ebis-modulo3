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
        Schema::table('index_funds', function (Blueprint $table) {
            $table->decimal('current_price', 10, 2)->default(100.00)->after('aum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('index_funds', function (Blueprint $table) {
            $table->dropColumn('current_price');
        });
    }
};
