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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string("customer_name");
            $table->string("customer_email");

            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string("subtotal");
            $table->string("discount");
            $table->string("tax");
            $table->string("shipping");

            $table->string("total");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
