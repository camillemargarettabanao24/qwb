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
        Schema::create('wedding_package_shopping_basket', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('wedding_package_id');
            $table->unsignedBigInteger('wedding_package_images_id');
            
            $table->string('bride_gown');
            $table->string('bride_color');

            $table->string('groom_suit');
            $table->string('groom_color');

            $table->string('maid_of_honor');
            $table->string('moh_color');

            $table->string('bestman');
            $table->string('bestman_color');

            $table->string('bridesmaid_set');
            $table->string('bridesmaid_set_color');

            $table->string('groomsmen_set');
            $table->string('groomsmen_set_color');

            $table->string('bearers_set');
            $table->string('bearers_set_color');

            $table->string('flowerG_set');
            $table->string('flowerG_set_color');
            
            $table->string('bride_father');
            $table->string('bride_father_color');

            $table->string('groom_father');
            $table->string('groom_father_color');

            $table->string('bride_mother');
            $table->string('bride_mother_color');

            $table->string('groom_mother');
            $table->string('groom_mother_color');
            
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('wedding_package_id')->references('id')->on('wedding_package');
            $table->foreign('wedding_package_images_id')
            ->references('id')
            ->on('wedding_package_images')
            ->name('wp_sb_wp_images_fk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
