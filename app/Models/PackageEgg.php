<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageEgg extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'package_egg';

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'package_id',
        'egg_menu_id',
        'order_id'
    ];
    
    /**
     * Define relation
     */
    public function egg() {
        return $this->hasOne(EggMenu::class, 'id', 'egg_menu_id');
    }
}
