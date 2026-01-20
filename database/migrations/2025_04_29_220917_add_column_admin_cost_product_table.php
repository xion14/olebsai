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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_cost_id')->nullable()->after('id');
            $table->double('seller_price')->nullable()->after('price'); // gunakan double
            $table->double('admin_cost')->nullable()->after('seller_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['admin_cost_id', 'seller_price', 'admin_cost']);
        });
    }
};
