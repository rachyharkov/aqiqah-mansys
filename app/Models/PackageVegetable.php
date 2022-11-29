<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageVegetable extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'package_vegetable';

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'package_id',
        'vegetable_menu_id',
        'order_id'
    ];
    
    /**
     * Define relation
     */
    public function vegie() {
        return $this->hasOne(VegetableMenu::class, 'id', 'vegetable_menu_id');
    }
}
