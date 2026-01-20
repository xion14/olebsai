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
        Schema::create('setting_unit_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('activity', 50);
            $table->text('note')->nullable();
            $table->bigInteger('setting_unit_id');
            $table->timestamps();

            $table->index(['setting_unit_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_unit_logs');
    }
};
