<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianPropertiDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function properti()
    {
        return $this->hasMany('App\Models\PropertiFoto', 'transaction_id', 'id');
    }
}
