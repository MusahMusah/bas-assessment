<?php

namespace App\Console\Commands;

use App\Services\SalaryPaymentService;
use App\Services\Service2;
use App\Services\Service3;
use App\Services\Service4;
use App\Services\Service5;
use Illuminate\Console\Command;

class GenerateSalaryPaymentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salary:payment-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate salary payment dates for the sales department';
    private SalaryPaymentService $salaryPaymentService;
    public function __construct(SalaryPaymentService $salaryPaymentService)
    {
        parent::__construct();

        $this->salaryPaymentService = $salaryPaymentService;
    }


    public function handle()
    {
        $paymentDates = $this->salaryPaymentService->calculatePaymentDates(date("Y"));
        $this->salaryPaymentService->generateCSV($paymentDates);
    }
}
