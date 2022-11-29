<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\UserCabang;
use App\Models\UsersBranch;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Define relation
     */
    public function roles(){
        return $this->belongsTo(Role::class, 'roles_id', 'id');
    }

    /**
     * Define relation to user cabang
     */
    public function userBranch() {
        return $this->belongsTo(UsersBranch::class, 'id', 'branch_id');
    }

    /**
     * Defiene relation
     */
    public function branches() {
        return $this->hasOne(UsersBranch::class, 'users_id', 'id');
    }

    public function canSeeAllBranches()
    {
        return in_array($this->roles_id, [
            6,
            7,
            8,
        ]);
    }
}
