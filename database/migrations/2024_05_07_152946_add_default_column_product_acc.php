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
        Schema::table('product_accessories', function (Blueprint $table) {
            $table->string('accessory')->default('None')->change();
            $table->integer('quantity')->default(0)->change();
            $table->bigInteger('price')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_accessories', function (Blueprint $table) {
            //
        });
    }
};
