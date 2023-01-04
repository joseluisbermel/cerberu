<?php
namespace App\Importers;

use App\Observer\ImportObservable;
use App\Observer\ImportObserver;

abstract class ReservationsImporter implements ImportObservable
{

    const EVENT_ITEM_INFO = 1;
    const EVENT_ITEM_ERROR = 2;

    /**
     * File Path
     * @var string
     */
    protected $filePath;

    /**
     * Observers
     * @var array
     */
    protected $observers = [];

    /**
     * Constructor
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Get File Path
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Add Observer
     * @param ImportObserver $objLogger
     * @param string $eventType
     * @return void
     */
    public function addObserver(ImportObserver $objLogger, string $eventType): void
    {
        $this->observers[$eventType][] = $objLogger;
    }

    /**
     * Fire Event
     * @param string $eventType
     * @param string $message
     * @return void
     */
    public function fireEvent(string $eventType, string $message): void
    {
        if (isset($this->observers[$eventType]) && is_array($this->observers[$eventType])) {
            foreach ($this->observers[$eventType] as $objObserver) {
                $objObserver->notify($this, $message);
            }
        }
    }

    abstract function import(): void;
}
