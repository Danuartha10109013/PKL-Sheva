<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostM extends Model
{
    use HasFactory;

    protected $table = 'post';

    protected $fillable = [
        'user_id',
        'forum_id',
        'file',
        'judul',
        'desc',
];
}
