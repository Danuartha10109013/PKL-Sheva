<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class forumM extends Model
{
    use HasFactory;

    protected $table = 'forum';

    protected $fillable = [
        'project_id',
        'user_id',
        'chat',
    ];
}
