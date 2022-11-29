<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPackage extends Model
{
    /**
     * Define table
     * @var string
     */
    protected $table = 'orders_package';

    /**
     * set fillable field
     */
    protected $fillable = [
        'order_id',
        'package_id'
    ];

    /**
     * Set hidden field
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Define relation
     */
    public function package() {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }

    /**
     * Define relation
     */
    public function meat() {
        return $this->hasOne(PackageMeat::class, 'order_id', 'id');
    }

    /**
     * Define relation
     */
    public function egg() {
        return $this->hasOne(PackageEgg::class, 'order_id', 'id');
    }

    /**
     * Define relation
     */
    public function chicken() {
        return $this->hasOne(PackageChicken::class, 'order_id', 'id');
    }

    /**
     * Define relation
     */
    public function offal() {
        return $this->hasOne(PackageOffal::class, 'order_id', 'id', 'id');
    }

    /**
     * Define relation
     */
    public function vegie() {
        return $this->hasOne(PackageVegetable::class, 'order_id', 'id');
    }

    /**
     * Define relation
     */
    public function rice() {
        return $this->hasOne(PackageRice::class, 'order_id', 'id');
    }
}
