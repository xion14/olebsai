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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->Integer('seller_id');
            $table->string('code', 16)->unique();
            $table->string('name');
            $table->Integer('category_id');
            $table->Integer('unit_id');
            $table->Integer('stock');
            $table->bigInteger('price');
            $table->string('slug')->nullable();
            $table->string('image_1', 100);
            $table->string('image_2', 100)->nullable();
            $table->string('image_3', 100)->nullable();
            $table->string('image_4', 100)->nullable();
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
