<?php

namespace App;

use App\Traits\CompanyScoped;
use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
    use CompanyScoped;

    protected $table = 'transporters';
}
