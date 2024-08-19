<?php

namespace Diaa\PayDates;

use DateTime;
use Exception;

class MonthRecord
{
    const WEEkEND_DAY = ['SAT', 'SUN'];
    private $currentYear;

    public function __construct(private $month)
    {
        $this->currentYear = date('Y');
    }

    /**
     * @return string
     * @throws PayDatesException
     */
    public function getMonthName(): string
    {
        try {
            $this->month = str_pad($this->month, 2, "0", STR_PAD_LEFT);
            $date = "{$this->currentYear}-{$this->month}-01";
            echo "$date \n";
            $dateTime = new DateTime($date);
            return $dateTime->format('M');
        } catch (Exception $exception) {
            throw new PayDatesException('INVALID MONTH DATE');
        }
    }

    public function getSalaryDate()
    {
        $date = new DateTime();
        $date->setDate($this->currentYear, intval($this->month), 1); // Set the date to the first day of the specified month
        $date->modify('+1 month');
        $date->modify('-1 day');
        return $this->firstWeekDay($date);
    }

    /**
     * @param DateTime $date
     * @return string
     */
    public function firstWeekDay(DateTime $date): string
    {
        $lastDay = $date->format('D');
        if ($lastDay == 'Sat') {
            $date->modify('+2 day');
        } else if ($lastDay == 'Sun') {
            $date->modify('+1 day');
        }
        return $date->format('Y-m-d');
    }

    public function getBonusDate()
    {
        $date = new DateTime();
        $date->setDate($this->currentYear, intval($this->month), 15); // Set the date to the first day of the specified month
        return $this->firstWeekDay($date);
    }
}