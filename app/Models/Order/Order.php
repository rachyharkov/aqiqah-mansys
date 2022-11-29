<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function custInformation(){
    	return $this->hasOne(CustInformation::class, 'order_id', 'id');
    }

    public function orderInformation(){
    	return $this->hasOne(OrderInformation::class, 'order_id', 'id');
    }
}
