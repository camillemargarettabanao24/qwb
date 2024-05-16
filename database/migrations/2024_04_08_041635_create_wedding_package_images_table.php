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
        Schema::create('wedding_package_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wedding_package_id');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('wedding_package_id')->references('id')->on('wedding_package');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
