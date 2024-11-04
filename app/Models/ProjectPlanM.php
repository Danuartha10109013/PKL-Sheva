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
        'pernyataan',
        'catatan',
    ];
}
