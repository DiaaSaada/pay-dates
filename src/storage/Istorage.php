<?php

namespace Diaa\PayDates\storage;

interface Istorage
{

    public function loadArrayFromCSV(string $filePath): array;

    public function writeArrayToCsvFile($filePath, $csvData): void;

    public function getFilepath($year): string;


}