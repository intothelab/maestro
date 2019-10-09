<?php

namespace App;

use App\Traits\CompanyScoped;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transporter extends Model
{
    use SoftDeletes;
    use SpatialTrait;

    protected $table = 'transporters';
    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'address',
        'postal_code',
        'number'
    ];

    protected $spatialFields = [
        'location',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class);
    }

}
