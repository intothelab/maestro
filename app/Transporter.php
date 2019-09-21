<?php

namespace App;

use App\Traits\CompanyScoped;
use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
    protected $table = 'transporters';

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class);
    }

}
