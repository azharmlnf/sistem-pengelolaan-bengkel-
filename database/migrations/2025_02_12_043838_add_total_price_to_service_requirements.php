<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('service_requirements', function (Blueprint $table) {
            $table->integer('total_price')->after('quantity')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('service_requirements', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }
};
