<?php

use Diaa\PayDates\MonthRecord;
use Diaa\PayDates\PayDatesException;
use Diaa\PayDates\storage\Istorage;
use Diaa\PayDates\storage\StorageFactory;

require 'vendor/autoload.php';

class PayDatesCommand
{

    /**
     * Execute the console command.
     */
    public static function run(): void
    {
        $options = self::readArgs();
        $year = $options['--year'] ?? date('Y');
        $store = $options['--store'] ?? 'file';

        /**
         * @var $storageHndlr Istorage
         */
        $storageHndlr = StorageFactory::create($store, $year);
        try {
            PayDatesCommand::handle($year, $storageHndlr);
        } catch (PayDatesException $e) {
            echo $e->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
            echo $e->getTraceAsString();
        }
    }

    /**
     * @return array
     */
    public static function readArgs(): array
    {
        $args = $_SERVER['argv'];
        $options = [];
        foreach ($args as $arg) {
            if (str_starts_with($arg, '--')) {
                list($key, $value) = explode('=', $arg);
                $options[$key] = $value;
            }
        }
        return $options;
    }

    /**
     * @throws PayDatesException
     */
    public static function handle(string $year, Istorage $storageHndlr): void
    {

        $filePath = $storageHndlr->getFilepath($year);

        $csvData = $storageHndlr->loadArrayFromCSV($filePath);

        $alreadyCalculatedMonths = count($csvData) - 1;  // subtract the header row

        if ($alreadyCalculatedMonths == 12) {
            echo "All Months have been calculated!\n";
            return;
        }
        for ($month = $alreadyCalculatedMonths + 1; $month <= 12; $month++) {
            $rec = new MonthRecord($year, $month);
            $csvData[] = [$rec->getMonthName(), $rec->getSalaryDate(), $rec->getBonusDate()];
        }
        $storageHndlr->writeArrayToCsvFile($filePath, $csvData);

    }
}

PayDatesCommand::run();
