<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_plan', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto-increment
            $table->string('project_id');
            $table->integer('status')->default(0);
            $table->string('no_projec_plan')->nullable();
            $table->string('no_rev')->default('0');
            $table->text('pengantar')->nullable();
            $table->text('ringkasan')->nullable();
            $table->text('ruang_lingkup')->nullable();
            $table->text('jadwal_proyek')->nullable();
            $table->json('fase')->nullable();
            $table->text('team_proyek')->nullable();
            $table->text('manajemen_proyek')->nullable();
            $table->text('fitur_utama')->nullable();
            $table->text('rincian_teknis')->nullable();
            $table->text('topologi')->nullable();
            $table->text('diagram')->nullable();
            $table->text('anggaran')->nullable();
            $table->text('nilai')->nullable();
            $table->text('pernyataan')->nullable();
            $table->text('catatan')->nullable();

            $table->text('pengantar_catatan')->nullable();
            $table->text('ringkasan_catatan')->nullable();
            $table->text('ruang_lingkup_catatan')->nullable();
            $table->integer('jadwal_proyek_catatan')->nullable();
            $table->text('team_proyek_catatan')->nullable();
            $table->text('manajemen_proyek_catatan')->nullable();
            $table->text('fitur_utama_catatan')->nullable();
            $table->text('rincian_teknis_catatan')->nullable();
            $table->text('topologi_catatan')->nullable();
            $table->text('diagram_catatan')->nullable();
            $table->text('anggaran_catatan')->nullable();
            $table->text('nilai_catatan')->nullable();
            $table->text('pernyataan_catatan')->nullable();
            $table->text('catatan_catatan')->nullable();

            $table->text('pengantar_catatantl')->nullable();
            $table->text('ringkasan_catatantl')->nullable();
            $table->text('ruang_lingkup_catatantl')->nullable();
            $table->text('jadwal_proyek_catatantl')->nullable();
            $table->text('team_proyek_catatantl')->nullable();
            $table->text('manajemen_proyek_catatantl')->nullable();
            $table->text('fitur_utama_catatantl')->nullable();
            $table->text('rincian_teknis_catatantl')->nullable();
            $table->text('topologi_catatantl')->nullable();
            $table->text('diagram_catatantl')->nullable();
            $table->text('anggaran_catatantl')->nullable();
            $table->text('nilai_catatantl')->nullable();
            $table->text('pernyataan_catatantl')->nullable();
            $table->text('catatan_catatantl')->nullable();

            $table->integer('update_by')->nullable();

            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_plan');
    }
};
