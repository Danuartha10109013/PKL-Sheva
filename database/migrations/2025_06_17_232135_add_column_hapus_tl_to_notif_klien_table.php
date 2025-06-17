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
        Schema::table('notif_klien', function (Blueprint $table) {
            $table->string('hapus')->default(0)->after('status_tl'); // ganti 'date' dengan kolom yang ingin didahului
            $table->string('hapus_tl')->default(0)->after('hapus'); // ganti 'date' dengan kolom yang ingin didahului
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notif_klien', function (Blueprint $table) {
            $table->dropColumn('hapus');
            $table->dropColumn('hapus_tl');
        });
    }
};
