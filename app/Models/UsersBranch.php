<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersBranch extends Model
{
     /**
     * Define table name
     * @var string
     */
    protected $table = 'users_branch';

    protected $fillable = [
        'users_id',
        'branch_id'
    ];

    public function branch() {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
