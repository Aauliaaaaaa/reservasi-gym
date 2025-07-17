<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'user_id',
        'jenis_kelamin',
        'no_telp',
        'alamat',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
