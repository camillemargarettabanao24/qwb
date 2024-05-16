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
        Schema::table('reservations', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['shopping_basket_id']);
            $table->dropForeign(['wp_basket_id']);
        
            // Optionally, you can also drop the foreign key columns if you don't need them anymore
            $table->dropColumn('shopping_basket_id');
            $table->dropColumn('wp_basket_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
        });
    }
};
