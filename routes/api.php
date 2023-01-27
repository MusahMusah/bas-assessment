<?php

use App\Services\SalaryPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/salary/payment-date', function (Request $request, SalaryPaymentService $salaryPaymentService) {
    $paymentDates = $salaryPaymentService->calculatePaymentDates($request->year);
    $salaryPaymentService->generateCSV($paymentDates);

    return response()->download("salary_payment_dates_{$request->year}.csv", "salary_payment_dates_{$request->year}.csv", ['Content-Type' => 'text/csv']);
})
->name('salary.payment-date');
