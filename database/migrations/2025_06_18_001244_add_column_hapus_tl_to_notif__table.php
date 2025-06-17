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
        Schema::table('notification', function (Blueprint $table) {
            $table->string('status_finance')->default(0)->after('status'); // ganti 'date' dengan kolom yang ingin didahului
            $table->string('hapus')->default(0)->after('status_finance'); // ganti 'date' dengan kolom yang ingin didahului
            $table->string('hapus_finance')->default(0)->after('hapus'); // ganti 'date' dengan kolom yang ingin didahului
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->dropColumn('status_finance'); 
            $table->dropColumn('hapus'); 
            $table->dropColumn('hapus_finance');
        });
    }
};
