<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'membership'; // Nama tabel yang benar
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'pelatih_id',
        'paket_id',
        'kategori',
        'sub_kategori',
        'tgl_datang',
        'tgl_mulai',
        'tgl_selesai',
        'bukti_bayar',
        'status',
        'status_selesai', // Pastikan 'status' ada di fillable
        'accepted_trainer',
        'reason',
    ];

    // Relasi tetap sama
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pelatih()
    {
        return $this->belongsTo(Pelatih::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function membershipDetails()
    {
        return $this->hasMany(MembershipDetail::class, 'membership_id');
    }
}