<?php

namespace Tests\Feature;

use App\Services\SalaryPaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SalaryPaymentServiceTest extends TestCase
{
    public function test_calculate_payment_dates(): void
    {
        // Arrange
        $payload = (new SalaryPaymentService())->calculatePaymentDates(date('Y'));
        $paymentDates = $payload['payment_dates'];

        // Assert that the payment dates array is not empty
        $this->assertNotEmpty($paymentDates);

        // Assert that the array contains the correct number of elements (remaining months of the year)
        $this->assertCount(12 - date("n") + 1, $paymentDates);

        // Assert that the array contains the correct data
        $this->assertArrayHasKey("month", $paymentDates[0]);
        $this->assertArrayHasKey("salary_payment_date", $paymentDates[0]);
        $this->assertArrayHasKey("bonus_payment_date", $paymentDates[0]);

        // Assert that the salary payment date is a valid date
        $this->assertTrue(checkdate(date("m", strtotime($paymentDates[0]["salary_payment_date"])), date("d", strtotime($paymentDates[0]["salary_payment_date"])), date("Y", strtotime($paymentDates[0]["salary_payment_date"]))));

        // Assert that the bonus payment date is a valid date
        $this->assertTrue(checkdate(date("m", strtotime($paymentDates[0]["bonus_payment_date"])), date("d", strtotime($paymentDates[0]["bonus_payment_date"])), date("Y", strtotime($paymentDates[0]["bonus_payment_date"]))));

        // Assert that the salary payment date is not on a weekend
        foreach ($paymentDates as $row) {
            $this->assertNotEquals("6", date("N", strtotime($row['salary_payment_date'])));
            $this->assertNotEquals("7", date("N", strtotime($row['salary_payment_date'])));
        }

        // Assert that the bonus payment date is not on a weekend, or on the 15th if the 15th is not a weekend
        foreach ($paymentDates as $row) {
            if (date("N", strtotime($row['bonus_payment_date'])) == 6) {
                $this->assertEquals("15", date("d", strtotime($row['bonus_payment_date'])));
            } else {
                $this->assertNotEquals("6", date("N", strtotime($row['bonus_payment_date'])));
                $this->assertNotEquals("7", date("N", strtotime($row['bonus_payment_date'])));
            }
        }

    }

    public function test_generate_csv(): void
    {
        // Arrange
        $payload = (new SalaryPaymentService())->calculatePaymentDates(date('Y'));
        (new SalaryPaymentService())->generateCSV($payload);


        // Assert that the CSV file exists
        $this->assertFileExists("salary_payment_dates_{$payload['year']}.csv");

        // Assert that the CSV is not empty
        $this->assertGreaterThan(0, filesize("salary_payment_dates_{$payload['year']}.csv"));

        // Assert that the CSV file contains the correct data
        $file = fopen("salary_payment_dates_{$payload['year']}.csv", "r");
        $header = fgetcsv($file);

        $this->assertEquals("Month", $header[0]);
        $this->assertEquals("Salary Payment Date", $header[1]);
        $this->assertEquals("Bonus Payment Date", $header[2]);

        $row = fgetcsv($file);
        $this->assertEquals(date("F"), $row[0]);
        $this->assertEquals(date("Y-m-d", strtotime("last day of this month")), $row[1]);

        // Assert that the CSV file contains the correct number of rows
        $this->assertCount(12 - date("n") + 2, file("salary_payment_dates_{$payload['year']}.csv"));

        // remove the CSV file
        unlink("salary_payment_dates_{$payload['year']}.csv");
    }
}
