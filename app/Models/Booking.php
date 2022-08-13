<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function paket()
    {
        return $this->belongsTo('App\Models\Paket', 'id_paket', 'id');
    }

    public function addOn()
    {
        return $this->hasMany('App\Models\AddOnBooking', 'id_booking', 'id');
    }

    public function hasilFoto()
    {
        return $this->hasMany('App\Models\HasilFoto', 'id_booking', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function pelanggan()
    {
        return $this->belongsTo('App\Models\Pelanggan', 'user_id', 'user_id');
    }
}
