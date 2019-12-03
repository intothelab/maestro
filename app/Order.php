<?php

namespace App;

use App\Events\OrderCreated;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $dispatchesEvents = [
        'created' => OrderCreated::class
    ];

    protected $fillable = [
        'company_cnpj',
        'customer_cnpj',
        'value',
        'weight',
        'adr_id'
    ];

    protected $hidden = [
        'adr_id'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'cnpj', 'customer_cnpj');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'cnpj', 'company_cnpj');
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }

    public function shipments() {
        return $this->belongsToMany(Shipment::class, 'shipments_orders');
    }
}
