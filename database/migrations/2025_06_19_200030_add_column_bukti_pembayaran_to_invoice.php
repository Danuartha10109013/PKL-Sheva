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
        Schema::table('invoice', function (Blueprint $table) {
            $table->string('bukti_pembayaran_30')->nullable(); // ganti 'date' dengan kolom yang ingin didahului
            $table->string('bukti_pembayaran_60')->nullable(); // ganti 'date' dengan kolom yang ingin didahului
            $table->string('bukti_pembayaran_90')->nullable(); // ganti 'date' dengan kolom yang ingin didahului
            $table->string('bukti_pembayaran_100')->nullable(); // ganti 'date' dengan kolom yang ingin didahului
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropColumn('bukti_pembayaran_30'); 
            $table->dropColumn('bukti_pembayaran_60'); 
            $table->dropColumn('bukti_pembayaran_90');
            $table->dropColumn('bukti_pembayaran_100');
        });
    }
};
