<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = 'orders';

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'package_id',
        'payment_id',
        'branch_id',
        'send_date',
        'number_of_goats',
        'gender_of_goats',
        'type_order_id',
        'maklon',
        'notes',
        'qty',
        'shipping_id',
        'additional_price',
        'discount_price',
        'total',
        'created_by'
    ];

    /**
     * Append new field to show
     */
    protected $appends = [
        'packageMenu'
    ];

    /**
     * Set value for new field
     */
    public function getPackageMenuAttribute() {
        $orderPackage = $this->orderPackage()->get();
        $newName = [];
        for ($a = 0; $a < count($orderPackage); $a++) {
            $newName[] = $orderPackage[$a]['package']['name'];
        }
        return implode(',', $newName);
    }

    /**
     * Define relation
     */
    public function createdBy() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    /**
     * Define relation
     */
    public function package() {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }

    /**
     * Define relation
     */
    public function orderPackage() {
        return $this->hasMany(OrderPackage::class, 'order_id', 'id');
    }

    /**
     * Define relation
     */
    public function customer() {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }

    /**
     * Define relation
     */
    public function branch() {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    /**
     * Define relation
     */
    public function shipping() {
        return $this->hasOne(Shipping::class, 'id', 'shipping_id');
    }

    /**
     * Define relation
     */
    public function payment() {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }
}
