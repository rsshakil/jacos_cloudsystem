<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\API\DATA\INVOICE\InvoiceController;
use App\Models\CMN\cmn_connect;
use App\Http\Controllers\API\SCHEDULE\InvoiceScheduleFunctions;

class InvoiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'invoice:scheduler {--start_date=00-00-00} {--end_date=00-00-00}';
    protected $signature = 'invoice:scheduler {arg=0}';

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
    public function __construct()
    {
        parent::__construct();
        $this->all_used_fun = new InvoiceScheduleFunctions();
        $this->invoice=new InvoiceController();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arg = $this->argument('arg');
        \Log::info($arg);
        // $this->comment($new_date);
        \Log::info("----Starting----");
        $today=date('y-m-d');
        $cmn_connect_info=cmn_connect::select('optional')->where('cmn_connect_id',1)->first();
        $optional=json_decode($cmn_connect_info->optional);
        $closing_date_array=$optional->invoice->closing_date;
        sort($closing_date_array);
        // $this->comment("closing_date_array ".$closing_date_array);
        $closing_date_array=$this->all_used_fun->arra_sorting($closing_date_array);
        $closing_date_count=count($closing_date_array);
        $start_date=null;
        $end_date=null;
        // \Log::info($closing_date_array);
        foreach ($closing_date_array as $key => $closing_day) {
            if ($arg==1) {
                $end_date = $today;
                if ($closing_date_count>1) {
                    if ($key!=0) {
                        $first_date=$this->all_used_fun->closing_date($closing_date_array[$key-1]);
                        $last_date=$this->all_used_fun->closing_date($closing_date_array[$key]);

                        $startDatedt = strtotime($first_date);
                        $endDatedt = strtotime($last_date);
                        $usrDatedt = strtotime($end_date);
                        if( $usrDatedt >= $startDatedt && $usrDatedt <= $endDatedt)
                        {
                            $start_date = date('y-m-d', strtotime("+1 day", strtotime($first_date)));
                        }
                    }
                }else{
                    $closing_date=$this->all_used_fun->closing_date($closing_day);
                    if (strtotime($closing_date) < strtotime($today)) {
                        $start_date = date('y-m-d', strtotime("+1 day", strtotime($closing_date)));
                    }else if(strtotime($closing_date) == strtotime($today)){
                        $start_date = $closing_date;
                    }else{
                        $start_date = $this->all_used_fun->start_date($closing_date, 1);
                    }
                }

            }else{
                $closing_date= $this->all_used_fun->closing_date($closing_day);
                if ($closing_date==$today) {
                    $end_date=$closing_date;
                    if ($closing_date_count>1) {
                        $array_key=array_search($closing_day,$closing_date_array);
                        if ($array_key==0) {
                            $array_end_date=$this->all_used_fun->closing_date(end($closing_date_array));
                            $start_date=$this->all_used_fun->first_start_date($array_end_date,$closing_date);
                        }else{
                            $start_date=$this->all_used_fun->another_start_date($closing_date_array[$key-1]);
                        }
                    }else{
                        $start_date=$this->all_used_fun->start_date($closing_date,1);
                    }
                }
            }
        }
        // Matched
        $this->comment("Invoice Running.....");
        $this->comment("Start Date: ".$start_date);
        $this->comment("End Date: ".$end_date);
        if ($start_date!=null && $end_date!=null) {
            $this->invoice->invoiceScheduler($start_date,$end_date);
            $this->comment("Done");
        }
        // Matched
    }
}
