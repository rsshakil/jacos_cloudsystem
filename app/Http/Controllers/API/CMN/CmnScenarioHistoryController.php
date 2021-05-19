<?php

namespace App\Http\Controllers\API\CMN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\CMN\cmn_scenario_history;

class CmnScenarioHistoryController extends Controller
{
    public $sc_history_array;

    public function __construct()
    {
        parent::__construct();
    }

    public function history_create($status, $information)
    {
        \Log::debug(__METHOD__.':start---');
        
        $status_text='success';
        if ($status === config('const.ERROR')) {
            \Log::error($information);
            $status_text='error';
        }

        $this->sc_history_array['status']=$status_text;
        $this->sc_history_array['information']=$information;
        cmn_scenario_history::insert($this->sc_history_array);

        \Log::debug(__METHOD__.':end---');
        return;
    }
}
