<?php

namespace App\Http\Controllers\API\DATA\INVOICE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\Cmn_ScenarioController;

class InvoiceController extends Controller
{
    private $request;
    public function __construct()
    {
        $this->request = new \Illuminate\Http\Request();
        $this->request->setMethod('POST');
    }
    public function invoiceScheduler(){
        // $request = new \Illuminate\Http\Request();
        // $request->setMethod('POST');
        $request=$this->request;
        $request->request->add(['scenario_id' => 15]);
        $request->request->add(['data_order_id' => 1]);
        $request->request->add(['email' => 'user@jacos.co.jp']);
        $request->request->add(['password' => 'Qe75ymSr']);
        // return $request->all();
        $cs = new Cmn_ScenarioController();
        return $ret = $cs->exec($request);
        \Log::debug($ret->getContent());
        $ret = json_decode($ret->getContent(), true);
        if (1 === $ret['status']) {
            // sceanario exec error
            \Log::error($ret['message']);
            return $ret;
        }
        return response()->json($ret);
    }
}
