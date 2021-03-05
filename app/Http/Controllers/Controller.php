<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $success;
    public $error;

    public function __construct()
    {
        $this->success = config('const.SUCCESS');
        $this->error = config('const.ERROR');
    }
    function mysession(){
        return session()->all();
    }
}
