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
        Schema::create('setting_costs', function (Blueprint $table) {
            $table->id();
            $table->integer('min_price');        // batas bawah
            $table->integer('max_price');        // batas atas
            $table->integer('cost_value');      // biaya yg dikenakan
            $table->string('description')->nullable(); // keterangan opsional
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_cost');
    }
};
