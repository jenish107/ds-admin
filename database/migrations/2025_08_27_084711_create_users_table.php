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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('userName');
            $table->string('email');
            $table->string('password');

            $table->unsignedBigInteger('country_id')->nullable()->default(null);
            $table->unsignedBigInteger('state_id')->nullable()->default(null);
            $table->unsignedBigInteger('city_id')->nullable()->default(null);

            $table->string('zipcode')->nullable()->default(null);
            $table->string('number')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->string('first_name')->nullable()->default(null);
            $table->string('last_name')->nullable()->default(null);

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
