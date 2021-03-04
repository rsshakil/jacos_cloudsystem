<?php

namespace App\Models\CMN;

use Illuminate\Database\Eloquent\Model;

class cmn_category extends Model
{
    //
    public function parent()
    {
        return $this->belongsTo('App\Models\CMN\cmn_category', 'parent_category_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\CMN\cmn_category', 'parent_category_id');
    }

    // recursive, loads all descendants
    public function recursiveChildren()
    {
       return $this->children()->with('recursiveChildren');
    }
}
