<?php

namespace Diaa\PayDates\storage;

class LocalStorage implements Istorage
{

    /**
     * @param $year
     * @return string
     */
    public function getFilepath($year): string
    {
        $dir = __DIR__ . "/../../output";
        $filePath = $dir . "/salaries-{$year}.csv";
        if (!is_dir($dir)) {
            mkdir($dir, 0555, true);
        }
        return $filePath;
    }

    public function loadArrayFromCSV(string $filePath): array
    {
        if (!file_exists($filePath)) {
            echo "File does not exist! Creating a new CSV file with headers...\n";
            // Define the headers
            $headers = ['Month', 'SalaryPayDate', 'BonusPayDate'];

            // Open the file for writing (create if not exists)
            $this->writeArrayToCsvFile($filePath, $headers);
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

    public function writeArrayToCsvFile($filePath, $csvData): void
    {
        $file = fopen($filePath, 'w');
        if (is_array($csvData[0])) {
            foreach ($csvData as $record) {
                // Write each record as a row in the CSV
                fputcsv($file, $record);
            }
        } else {
            // Write single line to the CSV file
            fputcsv($file, $csvData);
        }
        // Close the file
        fclose($file);
    }
}