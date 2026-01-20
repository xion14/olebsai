<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('type')->default(1); // 1 = product, 2 = shipping
            $table->double('percentage', 5, 2)->default(0); // misal 12.50 berarti 12.5%
            $table->double('max_discount', 15, 2)->nullable(); // maksimal potongan
            $table->double('minimum_transaction', 15, 2)->default(0); // minimum belanja
            $table->unsignedInteger('quota')->default(0); // kuota penggunaan
            $table->boolean('status')->default(1); // 1 = active, 0 = non-active
            $table->dateTime('start_date');
            $table->dateTime('expired_date');
            $table->unsignedBigInteger('user_created')->nullable();

            $table->foreign('user_created')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}

