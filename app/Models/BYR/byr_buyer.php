<?php

namespace App\Models\BYR;

use Illuminate\Database\Eloquent\Model;

class byr_buyer extends Model
{
    
    public function byr_company()
    {
        return $this->belongsTo('App\Models\BYR\cmn_company');
    }
}
