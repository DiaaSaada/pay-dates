<?php

namespace Diaa\PayDates\storage;

use Diaa\PayDates\PayDatesException;

class StorageFactory
{

    /**
     * @throws PayDatesException
     */
    public static function create(string $type): Istorage
    {
        switch ($type) {
            case 'file':
                return new LocalStorage();
            case 'cloud':
                return new CloudStorage();
        }
        throw new PayDatesException("Invalid storage type");
    }

}