<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCabang extends Model
{
    /**
     * Define table
     * @var string
     */
    protected $table = 'user_cabang';
    
    /**
     * Set hidden field
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Relation
     */
    public function branch() {
        return $this->hasOne(Cabang::class, 'id', 'cabang_id');
    }
}
