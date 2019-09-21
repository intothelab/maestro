<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
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
