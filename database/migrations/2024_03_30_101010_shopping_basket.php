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
    Schema::create('shopping_basket', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('customer_id');
        $table->unsignedBigInteger('product_id');
        $table->unsignedBigInteger('product_images_id');
        $table->string('color')->nullable();
        $table->string('size')->nullable();
        $table->unsignedInteger('quantity')->default(1);
        $table->string('accessories')->nullable();
        $table->timestamps();

        $table->foreign('customer_id')
              ->references('id')
              ->on('customers');

        $table->foreign('product_id')
              ->references('id')
              ->on('products');

        $table->foreign('product_images_id')
              ->references('id')
              ->on('product_images');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
