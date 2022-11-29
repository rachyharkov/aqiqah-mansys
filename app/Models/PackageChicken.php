<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageChicken extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'package_chicken';

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'package_id',
        'chicken_menu_id',
        'order_id'
    ];
    
    /**
     * Define relation
     */
    public function chicken() {
        return $this->hasOne(ChickenMenu::class, 'id', 'chicken_menu_id');
    }
}
