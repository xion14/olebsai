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
        Schema::create('seller_banners', function (Blueprint $table) {
            $table->id();
            $table->string('seller_id');
            $table->string('title');
            $table->string('subtitle');
            $table->string('description')->nullable();
            $table->string('image');
            $table->string('link');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_banner');
    }
};
