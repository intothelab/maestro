<?php
namespace App\Traits;

use App\Company;
use Illuminate\Support\Facades\Auth;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;



trait CompanyScoped
{
    protected static function bootCompanyScoped()
    {
        static::creating(function (Model $model) {
            $model->company_id = Auth::user()->company_id;
        });

        static::addGlobalScope(new CompanyScope());
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}