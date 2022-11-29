<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageMeat extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'package_meat';

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'package_id',
        'meat_menu_id',
        'order_id'
    ];
    
    /**
     * Define relation
     */
    public function meat() {
        return $this->hasOne(MeatMenu::class, 'id', 'meat_menu_id');
    }
}
