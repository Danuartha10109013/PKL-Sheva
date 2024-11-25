<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectM extends Model
{
    use HasFactory;

    protected $table = 'project';

    protected $fillable = [
        'judul',
        'customer_id',
        'pm_id',
        'start',
        'end',
        'biaya',
        'launch',
        'team_leader_id',
    ];
}
