<?php

namespace App;

use App\Events\OrderCreated;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @property int $id
 * @property string $company_cnpj
 * @property string $customer_cnpj
 * @property string|null $code
 * @property string|null branch
 * @property float $value
 * @property float $weight
 * @property float $cubic_weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $adr_id
 * @property-read \App\Company $company
 * @property-read \App\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Shipment[] $shipments
 * @property-read int|null $shipments_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAdrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCompanyCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCustomerCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereWeight($value)
 * @mixin \Eloquent
 */
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
        'cubic_weight',
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
