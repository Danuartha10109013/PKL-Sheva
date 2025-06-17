<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifKlienM extends Model
{
    use HasFactory;

    protected $table = 'notif_klien';

    protected $fillable = [
        'user_id',
            'title',
            'value',
            'project_id',
            'status',
            'status_tl',
            'hapus',
            'hapus_tl',
    ];
}
