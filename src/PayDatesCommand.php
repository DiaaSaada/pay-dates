<?php

use Diaa\PayDates\MonthRecord;
use Diaa\PayDates\PayDatesException;

require 'vendor/autoload.php'; // Composer autoload, if needed
class PayDatesCommand
{

    /**
     * Execute the console command.
     */
    public static function run()
    {
        try {
            PayDatesCommand::handle();
        } catch (PayDatesException $e) {
            echo $e->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
            echo $e->getTraceAsString();
        }
    }

    public static function handle(): void
    {

        $filePath = self::getFilepath();

        $csvData = self::loadArrayFromCSV($filePath);

        $alreadyCalculatedMonths = count($csvData) - 1;  // subtract the header row

        if ($alreadyCalculatedMonths == 12) {
            echo "All Months have been calculated!\n";
            return;
        }
        for ($month = $alreadyCalculatedMonths + 1; $month <= 12; $month++) {
            $rec = new MonthRecord($month);
            $csvData[] = [$rec->getMonthName(), $rec->getSalaryDate(), $rec->getBonusDate()];
        }
        self::writeArrayToCsvFile($filePath, $csvData);

    }

    /**
     * @return string
     */
    public static function getFilepath(): string
    {
        $year = date('Y');
        $filePath = __DIR__ . "/../salaries-{$year}.csv";
        return $filePath;
    }

    /**
     * @param string $filePath
     * @return array
     */
    public static function loadArrayFromCSV(string $filePath): array
    {
        if (!file_exists($filePath)) {
            echo "File does not exist! Creating a new CSV file with headers...\n";
            // Define the headers
            $headers = ['Month', 'SalaryPayDate', 'BonusPayDate'];

            // Open the file for writing (create if not exists)
            self::writeArrayToCsvFile($filePath, $headers);
        }
        echo "File exists! Loading the CSV data into an array...\n";

        // Load CSV into an array
        $csvData = array_map('str_getcsv', file($filePath));
        // Remove any empty lines
        $csvData = array_filter($csvData, function ($row) {
            // Filter out empty rows or rows where all values are empty
            return !empty(array_filter($row));
        });
        return $csvData;
    }

    /**
     * @param $filePath
     * @param array $data
     * @return void
     */
    public static function writeArrayToCsvFile($filePath, array $data)
    {
        $file = fopen($filePath, 'w');

        if (is_array($data[0])) {
            foreach ($data as $record) {
                // Write each record as a row in the CSV
                fputcsv($file, $record);
            }
        } else {
            // Write single line to the CSV file
            fputcsv($file, $data);
        }
        // Close the file
        fclose($file);
    }
}

PayDatesCommand::handle();
