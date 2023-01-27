<?php

namespace App\Services;

class SalaryPaymentService
{
    public function calculatePaymentDates(int $currentYear): array
    {
        // Initialize an empty array to store the payment dates
        $paymentDates = array();

        // Loop through the remaining months of the year
        for ($i = date("n"); $i <= 12; $i++) {
            // Get the name of the month
            $monthName = date("F", mktime(0, 0, 0, $i, 1));

            // Calculate the last day of the month
            $lastDayOfMonth = date("t", mktime(0, 0, 0, $i, 1));

            // Calculate the salary payment date
            $salaryPaymentDate = date("Y-m-d", mktime(0, 0, 0, $i, $lastDayOfMonth, $currentYear));
            while (date("N", strtotime($salaryPaymentDate)) >= 6) {
                $salaryPaymentDate = date("Y-m-d", strtotime("-1 day", strtotime($salaryPaymentDate)));
            }

            // Calculate the bonus payment date
            $bonusPaymentDate = date("Y-m-d", mktime(0, 0, 0, $i, 15, $currentYear));
            // start from next month
            $bonusPaymentDate = date("Y-m-d", strtotime("+1 month", strtotime($bonusPaymentDate)));
            if (date("N", strtotime($bonusPaymentDate)) >= 6) {
                $bonusPaymentDate = date("Y-m-d", strtotime("next wednesday", strtotime($bonusPaymentDate)));
            }

            // Add the payment dates to the array
            $paymentDates[] = array(
                "month" => $monthName,
                "salary_payment_date" => $salaryPaymentDate,
                "bonus_payment_date" => $bonusPaymentDate
            );
        }

        // Return the payment dates array
        return [
            "payment_dates" => $paymentDates,
            "year" => $currentYear
        ];
    }

    public function generateCSV(array $payload): void
    {
        // Open the file for writing
        $file = fopen("salary_payment_dates_{$payload['year']}.csv", "w");

        // Write the header row
        fputcsv($file, array("Month", "Salary Payment Date", "Bonus Payment Date"));

        // Write the data rows
        foreach ($payload['payment_dates'] as $row) {
            fputcsv($file, $row);
        }

        // Close the file
        fclose($file);
    }
}
