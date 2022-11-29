<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'branch';

    protected $fillable = [
        'name'
    ];

    /**
     * Define relation
     */
    public function userBranch() {
        return $this->hasMany(UsersBranch::class, 'branch_id', 'id');
    }

    /**
     * Define relation
     */
    public function orders() {
        return $this->hasMany(Orders::class, 'branch_id', 'id');
    }
}
