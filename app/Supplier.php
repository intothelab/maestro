<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'cnpj', 'email', 'phone', 'contact_name', 'contact_phone', 'description', 'location', 'zipcode', 'address'];
}
