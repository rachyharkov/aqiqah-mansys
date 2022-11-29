<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
     /**
     * Define table name
     * @var string
     */
    protected $table = 'payment';

    protected $fillable = [
        'name'
    ];
}
