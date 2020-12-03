<?php

namespace App\Models\SLR;

use Illuminate\Database\Eloquent\Model;

class slr_seller extends Model
{
    public function slr_companies()
    {
        return $this->hasMany('App\Models\CMN\cmn_company', 'cmn_company_id', 'slr_seller_id');
    }
}
