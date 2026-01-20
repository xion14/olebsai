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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id')->nullable();
            $table->bigInteger('customer_id');
            $table->bigInteger('customer_address_id');
            $table->string('code', 50)->unique();
            $table->bigInteger('subtotal')->default(0);
            $table->bigInteger('other_cost')->default(0);
            $table->bigInteger('total')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->String('payment_method')->nullable();
            $table->String('payment_channel')->nullable();
            $table->String('snap_token')->nullable();
            $table->String('shipping_number')->nullable();
            $table->Double('shipping_cost')->default(0);
            $table->String('shipping_name')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
