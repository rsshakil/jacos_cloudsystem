<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\API\DATA\INVOICE\InvoiceController;
use App\Models\CMN\cmn_connect;
use App\Http\Controllers\API\SCHEDULE\InvoiceScheduleFunctions;
use App\Models\ADM\User;
use App\Http\Controllers\API\AllUsedFunction;
use Illuminate\Support\Facades\Log;

class InvoiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'invoice:scheduler {--start_date=00-00-00} {--end_date=00-00-00}';
    // protected $signature = 'invoice:scheduler {arg=0} {data_order_id=null}';
    protected $signature = 'invoice:scheduler {arg=0} {adm_user_id=0} {byr_buyer_id=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoice scheduler command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $all_used_fun;
    private $invoice;
    private $global_functions;
    public function __construct()
    {
        parent::__construct();
        $this->all_used_fun = new InvoiceScheduleFunctions();
        $this->invoice=new InvoiceController();
        $this->global_functions=new AllUsedFunction();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arg = $this->argument('arg');
        $adm_user_id = $this->argument('adm_user_id');
        $byr_buyer_id = $this->argument('byr_buyer_id');

        $cmn_connect_id = '';
        if ($arg!=0 && $adm_user_id!=0 && $byr_buyer_id!=0) {
            $authUser = User::find($adm_user_id);
            if (!$authUser->hasRole(config('const.adm_role_name'))) {
                $cmn_company_info=$this->global_functions->get_user_info($adm_user_id, $byr_buyer_id);
                $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
            }
            $this->invoiceSchedulerCode($arg, $cmn_connect_id);
        } else {
            $cmn_connects=cmn_connect::select('cmn_connect_id')->get();
            foreach ($cmn_connects as $key => $cmn_connect) {
                $this->invoiceSchedulerCode($arg, $cmn_connect->cmn_connect_id);
            }
        }


        // Matched
    }
    public function invoiceSchedulerCode($arg, $cmn_connect_id)
    {
        Log::info("----invoiceSchedulerCode Starting----");
        $today=date('y-m-d');
        $first_day_of_month=date('y-m-01');
        $cmn_connect_info=cmn_connect::select('optional')->where('cmn_connect_id', $cmn_connect_id)->first();
        $optional=json_decode($cmn_connect_info->optional);
        $closing_date_array=$optional->invoice->closing_date;
        sort($closing_date_array);

        $closing_date_array=$this->all_used_fun->arra_sorting($closing_date_array);
        $closing_date_count=count($closing_date_array);
        $start_date=null;
        $end_date=null;
        if ($arg==1) {
            $closing_date_array_full=array();
            $end_date=$today;
            foreach ($closing_date_array as $key1 => $value) {
                $closing_date_array_full[]=$this->all_used_fun->closing_date($value);
            }
            // Log::info($closing_date_array_full);
            foreach ($closing_date_array_full as $key => $closing_day) {
                $array_first_date=$this->all_used_fun->closing_date($closing_date_array[array_key_first($closing_date_array)]);
                $array_end_date=$this->all_used_fun->closing_date(end($closing_date_array));
                $startDatedt = strtotime($closing_date_array_full[$key]);
                $compareDate = strtotime($today);
                // if (array_key_exists([$key+1], $closing_date_array_full)) {
                if (($key+1)!=count($closing_date_array_full)) {
                    $endDatedt = strtotime($closing_date_array_full[$key+1]);
                    if ($compareDate > $startDatedt && $compareDate <= $endDatedt) {
                        if ($arg!=1) {
                            $this->comment($start_date);
                        }
                        $start_date = date('y-m-d',$endDatedt);
                        break;
                    }
                }

                if ($start_date==null) {
                    $first_day_of_monthdt = strtotime($first_day_of_month);
                    $first_date_of_array = strtotime($array_first_date);
                    if ($compareDate >= $first_day_of_monthdt && $compareDate <= $first_date_of_array) {
                        $start_date=date("y-m-d", strtotime("-1 months",strtotime($array_end_date)));
                        if ($start_date!=$end_date) {
                            $bbb=strtotime($start_date);
                            $start_date = date('y-m-d', strtotime("+1 day", $bbb));
                        }

                        break;
                    }
                    $last_day_of_month= $this->all_used_fun->closing_date('last');
                    $last_day_of_monthdt = strtotime($last_day_of_month);
                    $array_end_datedt = strtotime($array_end_date);
                    if ($compareDate >= $array_end_datedt && $compareDate <= $last_day_of_monthdt) {
                        $start_date = $array_end_date;
                        break;
                    }
                }

                Log::info('=====Start=======');
                Log::info($start_date);
                Log::info($end_date);
                Log::info('============');
            }
        }else{
            // Auto
            foreach ($closing_date_array as $key => $closing_day) {
                $closing_date= $this->all_used_fun->closing_date($closing_day);
                if ($closing_date==$today) {
                    $end_date=$closing_date;
                    if ($closing_date_count>1) {
                        $array_key=array_search($closing_day, $closing_date_array);
                        if ($array_key==0) {
                            $array_end_date=$this->all_used_fun->closing_date(end($closing_date_array));
                            $start_date=$this->all_used_fun->first_start_date($array_end_date, $closing_date);
                        } else {
                            $start_date=$this->all_used_fun->another_start_date($closing_date_array[$key-1]);
                        }
                    } else {
                        $start_date=$this->all_used_fun->start_date($closing_date, 1);
                    }
                }
            }
        }
// Matched
        if ($arg!=1) {
            $this->comment("Invoice Running.....");
            $this->comment("cmn_connect: ".$cmn_connect_id);
            $this->comment("Start Date: ".$start_date);
            $this->comment("End Date: ".$end_date);
        }

        if ($start_date!=null && $end_date!=null) {
            Log::info('=====Last Final=======');
            Log::info($start_date);
            Log::info($end_date);
            Log::info('============');
            $request = new \Illuminate\Http\Request();
            $request->setMethod('POST');
            // $request=$this->request;
            $request->request->add(['scenario_id' => 15]);
            $request->request->add(['cmn_connect_id' => $cmn_connect_id]);
            $request->request->add(['start_date' => $start_date]);
            $request->request->add(['end_date' => $end_date]);
            $aaa=$this->invoice->invoiceScheduler($request);
            if ($arg!=1) {
                $this->comment("Done");
            }
            return $aaa;
        }
        Log::info("----invoiceSchedulerCode end----");
    }
}
