<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot() {
        parent::boot();

        static::deleting(function($paket) {
            $paket->jumlah_cetakan()->delete();
            $paket->biaya_lainnya()->delete();
        });
    }

    public function jumlah_cetakan()
    {
        return $this->hasMany('App\Models\JumlahCetakan', 'paket_id', 'id');
    }

    public function biaya_lainnya()
    {
        return $this->hasMany('App\Models\BiayaLainnya', 'paket_id', 'id');
    }
}
