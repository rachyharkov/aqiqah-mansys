<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'cabang';

    /**
     * Set hidden field
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    /**
     * Set fillable database field
     * @var array
     */
    protected $fillable = [
        'nama',
        'alamat'
    ];
}
