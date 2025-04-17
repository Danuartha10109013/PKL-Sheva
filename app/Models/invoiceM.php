<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoiceM extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $fillable = [
        'project_id',
        'no_invoice',
        'kepada',
        'npwp',
        'alamat',
        'pembuat',
        'date',
        'due_date',
        'ppn',
    ];
}
