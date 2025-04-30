<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryM extends Model
{
    use HasFactory;

    protected $table = 'history'; // sesuaikan jika nama tabel berbeda

    protected $fillable = [
        'project_id',
        'invoice',
        'no_invoice',
        'dueDate',
        'date',
        'kepada',
        'npwp',
        'alamat',
        'subTotal',
        'no',
        'deskripsi',
        'unit',
        'harga',
        'jumlah',
        'ppn',
        'terbilang',
        'total',
        'pembuat',
    ];
}
