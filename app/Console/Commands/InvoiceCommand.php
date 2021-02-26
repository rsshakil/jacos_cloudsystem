<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\API\DATA\INVOICE\InvoiceController;

class InvoiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:scheduler';

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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $invoice=new InvoiceController();
        $invoice->invoiceScheduler();
        // $drip->send(User::find($this->argument('user')));
    }
}
