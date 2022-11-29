<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageRice extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'package_rice';

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'package_id',
        'rice_menu_id',
        'order_id'
    ];
    
    /**
     * Define relation
     */
    public function rice() {
        return $this->hasOne(RiceMenu::class, 'id', 'rice_menu_id');
    }
}
