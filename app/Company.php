<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    public function documents()
    {
        return $this->hasMany(Document::class, 'company_cnpj', 'cnpj');
    }

}
