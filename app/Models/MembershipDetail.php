<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipDetail extends Model
{
    protected $fillable = [
        'membership_id',
        'tgl_datang',
        'jam_mulai',
        'jam_selesai',
        'selesai',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }
}
