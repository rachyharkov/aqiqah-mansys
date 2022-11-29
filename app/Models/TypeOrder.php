<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeOrder extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'type_order';

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
