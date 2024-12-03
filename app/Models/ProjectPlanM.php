<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPlanM extends Model
{
    use HasFactory;

    protected $table = 'project_plan';

    protected $fillable = [
        'project_id',
        'pengantar',
        'ringkasan',
        'ruang_lingkup',
        'jadwal_proyek',
        'fase',
        'team_proyek',
        'manajemen_proyek',
        'fitur_utama',
        'rincian_teknis',
        'topologi',
        'diagram',
        'anggaran',
        'nilai',
        'pernyataan',
        'catatan',
        'no_rev',
        'no_projec_plan',

        'pengantar_catatan',
        'ringkasan_catatan',
        'ruang_lingkup_catatan',
        'jadwal_proyek_catatan',
        'fase_1_catatan',
        'team_proyek_catatan',
        'manajemen_proyek_catatan',
        'fitur_utama_catatan',
        'rincian_teknis_catatan',
        'topologi_catatan',
        'diagram_catatan',
        'anggaran_catatan',
        'nilai_catatan',
        'pernyataan_catatan',
        'catatan_catatan',

        'pengantar_catatantl',
        'ringkasan_catatantl',
        'ruang_lingkup_catatantl',
        'jadwal_proyek_catatantl',
        'fase_1_catatantl',
        'team_proyek_catatantl',
        'manajemen_proyek_catatantl',
        'fitur_utama_catatantl',
        'rincian_teknis_catatantl',
        'topologi_catatantl',
        'diagram_catatantl',
        'anggaran_catatantl',
        'nilai_catatantl',
        'pernyataan_catatantl',
        'catatan_catatantl',

        'status',
    ];
}
