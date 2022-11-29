<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    /**
     * define relation
     */
    public function userRole() {
        return $this->hasMany(User::class, 'roles_id', 'id');
    }
}
