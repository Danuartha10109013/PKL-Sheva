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
            $table->string('status_tl')->default(0)->after('status'); // ganti 'date' dengan kolom yang ingin didahului
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notif_klien', function (Blueprint $table) {
            $table->dropColumn('status_tl');
        });
    }
};
