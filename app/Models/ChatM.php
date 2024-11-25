<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatM extends Model
{
    use HasFactory;

    protected $table = 'chat';

    protected $fillable = [
        'forum_id',
        'project_id',
        'user_id',
        'chat',
        'file',
    ];
}
