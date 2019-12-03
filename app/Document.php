<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Document
 *
 * @property int $id
 * @property string|null $nfe_id
 * @property int $number
 * @property int $series
 * @property string|null $transporter_cnpj
 * @property string|null $company_cnpj
 * @property string|null $customer_cnpj
 * @property int|null $order_id
 * @property string|null $collected_at
 * @property string|null $delivered_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Company $company
 * @property-read \App\Customer $customer
 * @property-read \App\Order|null $order
 * @property-read \App\Transporter $transporter
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereCollectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereCompanyCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereCustomerCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereNfeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereTransporterCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Document extends Model
{

    protected $fillable = ['transporter_cnpj', 'company_cnpj', 'order_id', 'collected_at', 'delivered_at'];

    public function transporter(){
        return $this->hasOne(Transporter::class, 'cnpj', 'transporter_cnpj');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'cnpj', 'customer_cnpj');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'cnpj',  'company_cnpj');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
