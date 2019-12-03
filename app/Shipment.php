<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Shipment
 *
 * @property int $id
 * @property int|null $transporter_cnpj
 * @property string $code
 * @property string $invoice
 * @property float $weight
 * @property float $value
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Transporter $transporter
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment whereTransporterCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Shipment whereWeight($value)
 * @mixin \Eloquent
 */
class Shipment extends Model
{
    protected $table = 'shipments';

    public function orders(){
        return $this->belongsToMany(Order::class, 'shipments_orders');
    }

    public function transporter(){
        return $this->hasOne(Transporter::class, 'cnpj', 'transporter_cnpj');
    }

}
