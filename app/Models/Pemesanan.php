<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'pelanggan_id', 
        'jenis_iklan', 
        'tgl_pesan', 
        'tgl_tayang',
        'total_biaya', 
        'status', 
        'qty_atau_ukuran', 
        'bukti_terbit'
    ];
}
