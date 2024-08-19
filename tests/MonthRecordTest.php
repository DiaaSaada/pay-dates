<?php

declare(strict_types=1);

use Diaa\PayDates\MonthRecord;
use Diaa\PayDates\PayDatesException;
use PHPUnit\Framework\TestCase;

class MonthRecordTest extends TestCase
{
    /**
     * @throws PayDatesException
     */
    public function testGetMonthName(): void
    {
        $monthRecord = new MonthRecord(1);
        $this->assertEquals('Jan', $monthRecord->getMonthName());

        $monthRecord = new MonthRecord(12);
        $this->assertEquals('Dec', $monthRecord->getMonthName());
    }

    /**
     * @throws PayDatesException
     */
    public function testInvalidMonthName(): void
    {
        $this->expectException(PayDatesException::class);
        $monthRecord = new MonthRecord(0);
        $monthRecord->getMonthName();

        $this->expectException(PayDatesException::class);
        $monthRecord = new MonthRecord(13);
        $monthRecord->getMonthName();
    }

    public function testEndOfMonthIsSunday(): void
    {
        $monthRecord = new MonthRecord(3);
        $this->assertEquals('2024-04-01', $monthRecord->getSalaryDate());
    }

    public function test15thIsSun(): void
    {
        $monthRecord = new MonthRecord(9);
        $this->assertEquals('2024-09-16', $monthRecord->getBonusDate());
    }

    public function test15thIsSat(): void
    {
        $monthRecord = new MonthRecord(6);
        $this->assertEquals('2024-06-17', $monthRecord->getBonusDate());
    }
}