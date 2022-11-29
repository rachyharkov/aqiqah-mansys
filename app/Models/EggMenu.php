<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EggMenu extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'egg_menu';

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Set hidden field
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
