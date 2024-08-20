<?php

namespace Diaa\PayDates\storage;

use Exception;

class CloudStorage implements Istorage
{

    /**
     * @throws Exception
     */
    public function loadArrayFromCSV(string $filePath): array
    {
        throw new Exception("Not implemented");
    }

    /**
     * @throws Exception
     */
    public function writeArrayToCsvFile($filePath, $csvData): void
    {
        throw new Exception("Not implemented");
    }


    /**
     * @param $year
     * @return string
     * @throws Exception
     */
    public function getFilepath($year): string
    {
        throw new Exception("Not implemented");
    }
}