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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('car_id', 10);
            $table->foreign('car_id')->references('license_plate')->on('cars')->onDelete('cascade');
            $table->date('entry_date');
            $table->date('exit_date')->nullable();
            $table->text('complaint');
            $table->integer('price')->nullable();
            $table->enum('location', ['on bengkel', 'outside bengkel'])->default('on bengkel');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
