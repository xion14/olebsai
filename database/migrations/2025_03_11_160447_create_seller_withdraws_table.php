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
        Schema::create('seller_withdraws', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id');
            $table->string('code', 50)->unique();
            $table->double('amount');
            $table->dateTime('success_at')->nullable();
            $table->bigInteger('approval_by')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_withdraws');
    }
};
