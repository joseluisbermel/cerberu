<?php
namespace App\Loggers;

use App\Observer\ImportObservable;
use App\Observer\ImportObserver;
use App\Importers\ReservationsImporter;

class InfoLogger implements ImportObserver
{

    /**
     * Notify Observer
     * @param ImportObservable $objSource
     * @param string $message
     * @return void
     */
    public function notify(ImportObservable $objSource, string $message): void
    {
        if ($objSource instanceof ReservationsImporter) {
            printf('INFO -> %s.' . PHP_EOL, $message);
        }
    }
}
