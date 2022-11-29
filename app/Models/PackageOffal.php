<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageOffal extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'package_offal';

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'package_id',
        'offal_menu_id',
        'order_id'
    ];

    /**
     * Define relation
     */
    public function offal() {
        return $this->hasOne(OffalMenu::class, 'id', 'offal_menu_id');
    }
}
