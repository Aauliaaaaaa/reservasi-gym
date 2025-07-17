<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAlat extends Model
{
     use HasFactory;

    protected $table = 'detail_alat';

    protected $fillable = [
        'fasilitas_id',
        'tanggal',
        'foto',
        'kondisi',
    ];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'fasilitas_id');
    }
}
