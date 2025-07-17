<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
     use HasFactory;

    protected $fillable = [
        'nama',
        'foto',
        'keterangan',
    ];
    public function detailAlat()
    {
        return $this->hasMany(DetailAlat::class, 'fasilitas_id');
    }
}

