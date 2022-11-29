<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'shipping';

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
