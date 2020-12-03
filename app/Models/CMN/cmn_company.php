<?php

namespace App\Models\CMN;

use Illuminate\Database\Eloquent\Model;

class cmn_company extends Model
{
    public function byr_companies()
    {
        return $this->hasMany('App\Models\BYR\byr_buyer', 'cmn_company_id');
    }
    
}
