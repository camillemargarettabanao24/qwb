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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('shopping_basket_id');
            $table->unsignedBigInteger('wp_basket_id');
        
            $table->decimal('total_res_price', 8, 2);
            $table->decimal('downpayment', 8, 2)->default(0.00);
            $table->decimal('full_payment', 8, 2)->default(0.00);
            $table->decimal('balance', 8, 2)->default(0.00);

            $table->string('confirmation');
            $table->string('reservation_time');
            $table->date('reservation_date');
        
            $table->timestamps();
        
            // Define foreign key constraints
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('shopping_basket_id')->references('id')->on('shopping_basket');
            $table->foreign('wp_basket_id')->references('id')->on('wedding_package_shopping_basket');
        });    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations_');
    }
};
