<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatih extends Model
{
    use HasFactory;

    protected $table = 'pelatih';

    protected $fillable = [
        'user_id', 
        'paket_id', 
        'no_telp', 
        'alamat'
    ];

    // Relasi ke Paket
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'pelatih_id');
    }
}
