<?php

namespace App;

use App\Traits\CompanyScoped;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use CompanyScoped;

    protected $table = 'customers';
}
