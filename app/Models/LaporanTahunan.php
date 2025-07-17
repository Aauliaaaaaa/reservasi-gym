<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTahunan extends Model
{
    use HasFactory;

    protected $table = 'laporan_tahunan';

    protected $fillable = [
        'tahun',
        'total_pendapatan',
        'jumlah_member_baru',
        'total_member_aktif',
    ];
}
