<?php

namespace Diaa\PayDates;

use DateTime;
use Exception;

class MonthRecord
{
    const WEEkEND_DAY = ['SAT', 'SUN'];

    public function __construct(private string $year, private string $month)
    {
    }

    /**
     * @return string
     * @throws PayDatesException
     */
    public function getMonthName(): string
    {
        try {
            $this->month = str_pad($this->month, 2, "0", STR_PAD_LEFT);
            $date = "{$this->year}-{$this->month}-01";
            $dateTime = new DateTime($date);
            return $dateTime->format('M');
        } catch (Exception $exception) {
            throw new PayDatesException('INVALID MONTH DATE');
        }
    }

    public function getSalaryDate(): string
    {
        $date = new DateTime();
        $date->setDate($this->year, intval($this->month), 1); // Set the date to the first day of the specified month
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

    public function getBonusDate(): string
    {
        $date = new DateTime();
        $date->setDate($this->year, intval($this->month), 15);
        return $this->firstWeekDay($date);
    }
}