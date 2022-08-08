<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianProperti extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detail()
    {
        return $this->hasMany('App\Models\PembelianPropertiDetail', 'pembelian_properti_id', 'id')->with('properti');
    }

    public function kas()
    {
        return $this->hasOne('App\Models\KasBesar', 'transaction_id', 'id');
    }
}
