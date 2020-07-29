<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function homeLangData(){
        return str_replace('_', '-', app()->getLocale());
        return $locale = \App::getLocale();
        return $home_text =__('messages.welcome');
    }
    // $message,$string
    public function langString(){
        return $locale = \App::getLocale();
        return __('messages.role_name_required');
    }
}
