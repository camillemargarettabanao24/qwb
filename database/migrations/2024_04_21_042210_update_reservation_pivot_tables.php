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
        Schema::table('reservation_basket_pivot', function (Blueprint $table) {
            // Make shopping_basket_id nullable
            $table->unsignedBigInteger('shopping_basket_id')->nullable()->change();
        });

        Schema::table('reservation_wedding_package_basket_pivot', function (Blueprint $table) {
            // Make wp_basket_id nullable
            $table->unsignedBigInteger('wp_basket_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
