<?php

namespace App\Models\Paket;

use Illuminate\Database\Eloquent\Model;

class JenisPaketNasi extends Model
{
    public function nasi()
    {
        return $this->hasOne(Nasi::class, 'id', 'nasi_id');
    }
}
