<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifM extends Model
{
    use HasFactory;

    protected $table = 'notification';

    protected $fillable = [
        'user_id',
        'project_id',
        'invoice_id',
        'title',
        'value',
        'status',
    ];
}
