<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    public function transporter()
    {
        return $this->belongsTo(Transporter::class);
    }

}
