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
        Schema::create('cars', function (Blueprint $table) {
            $table->string('license_plate', 10)->primary(); // Primary Key
            $table->string('brand', 100);
            $table->enum('type', ['Truck', 'Car', 'Bus', 'Trailer', 'Pickup', 'Van', 'other'])->default('other');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('car_image')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
