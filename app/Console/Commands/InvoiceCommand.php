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
    protected $signature = 'invoice:scheduler {agr=0}';

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
        $new_date = $this->argument('agr');
        \Log::info($new_date);
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
        $start_date="00:00:00";
        $end_date="00:00:00";
        // \Log::info($closing_date_array);
        foreach ($closing_date_array as $key => $closing_day) {
            // $this->comment("closing_day ".$closing_day);
            $closing_date= $this->all_used_fun->closing_date($closing_day);
            // $this->comment("closing_date ".$closing_date);
            // $this->comment("Today ".$today);
            if ($closing_date==$today) {
                $end_date=$closing_date;
                if ($closing_date_count>1) {
                    $array_key=array_search($closing_day,$closing_date_array);
                    // \Log::info("Date Key ".$array_key);
                    // $this->comment("Date Key ".$array_key);
                    if ($array_key==0) {
                        $array_end_date=$this->all_used_fun->closing_date(end($closing_date_array));
                        $start_date=$this->all_used_fun->first_start_date($array_end_date,$closing_date);
                    }else{
                        $start_date=$this->all_used_fun->another_start_date($closing_date_array[$key-1]);
                    }
                }else{
                    $start_date=$this->all_used_fun->start_date($closing_date,1);
                    // $this->comment("Else date ".$start_date);
                }
                // Matched
                // \Log::info("Start Date: ".$start_date);
                // \Log::info("End Date: ".$end_date);
                $this->comment("Invoice Running.....");
                $this->comment("Start Date: ".$start_date);
                $this->comment("End Date: ".$end_date);
                $this->invoice->invoiceScheduler($start_date,$end_date);
                $this->comment("Done");
                // Matched
            }
        }
    }
}
