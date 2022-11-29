<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiceMenu extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'rice_menu';

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
