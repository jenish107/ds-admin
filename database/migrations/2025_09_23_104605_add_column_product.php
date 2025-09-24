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
        Schema::table('product', function (Blueprint $table) {
            $table->integer('sgst')->nullable();
            $table->integer('ugst')->nullable();
            $table->integer('cgst')->nullable();
            $table->integer('igst')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('sgst');
            $table->dropColumn('ugst');
            $table->dropColumn('cgst');
            $table->dropColumn('igst');
        });
    }
};
