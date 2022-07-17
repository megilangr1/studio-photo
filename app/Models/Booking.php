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
}
