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
        'fase_1',
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

        'status',
    ];
}
