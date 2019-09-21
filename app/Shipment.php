<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = 'shipments';

    public function orders(){
        return $this->belongsToMany(Order::class, 'shipments_orders');
    }

    public function transporter(){
        return $this->hasOne(Transporter::class);
    }

}
