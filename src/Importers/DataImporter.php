<?php
namespace App\Importers;

use App\Entity\Reservation;
use App\Importers\FileImporter\JsonImporter;
use App\Importers\FileImporter\XmlImporter;
use App\Importers\FileImporter\Elements\ElementInterface;
use App\Loggers\InfoLogger;
use App\Loggers\ErrorLogger;
use Doctrine\ORM\EntityManager;

/**
 * Class DataImporter
 *
 * @package App\Importers
 */
class DataImporter extends ReservationsImporter
{

    const InfoLogger = 'InfoLogger';
    const ErrorLogger = 'ErrorLogger';

    /**
     * List of reservations
     * @var array
     */
    private $reservations;

    /**
     * Entity Manager
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Constructor of DateImporter
     * @param string $filePath
     */
    public function __construct(string $filePath, EntityManager $entityManager)
    {
        parent::__construct($filePath);
        $this->entityManager = $entityManager;
        $this->reservations = [];
        $this->addObserver(new InfoLogger(), self::InfoLogger);
        $this->addObserver(new ErrorLogger(), self::ErrorLogger);
    }

    /**
     * Import datas from files
     * @return void
     */
    public function import(): void
    {
        $this->fireEvent(self::InfoLogger, '- Starting import process');
        $this->loadJson();
        $this->loadXml();
        $this->fireEvent(self::InfoLogger, '- Finishing import process');
    }

    /**
     * Load json file
     * @return void
     */
    private function loadJson(): void
    {
        $this->fireEvent(self::InfoLogger, '-- loadJson');
        foreach (glob($this->filePath . "/files/*.json") as $filename) {
            try {
                $jsonImporter = new JsonImporter($filename);
                $jsonImporter->load();
                $this->processElements($jsonImporter->getElements());
            } catch (\Exception $e) {
                $this->fireEvent(self::ErrorLogger, $e->getMessage());
            }
        }
    }

    /**
     * Load xml file
     * @return void
     */
    private function loadXml(): void
    {
        $this->fireEvent(self::InfoLogger, '-- loadXml');
        foreach (glob($this->filePath . "/files/*.xml") as $filename) {
            try {
                $xmlImporter = new XmlImporter($filename);
                $xmlImporter->load();
                $this->processElements($xmlImporter->getElements());
            } catch (\Exception $e) {
                $this->fireEvent(self::ErrorLogger, $e->getMessage());
            }
        }
    }

    /**
     * Process List and add reservation
     * @param ElementInterface $element
     * @return void
     */
    private function processElements(ElementInterface $element): void
    {
        foreach ($element->elements as $object) {
            try {
                $reservation = new Reservation(strval($object->title), intval($object->pax), floatval($object->total), strval($object->date), strval($object->link));
                if (!array_key_exists($reservation->getId(), $this->reservations)) {
                    $this->reservations[$reservation->getId()] = $reservation;
                    $this->saveEntity($reservation);
                    $this->fireEvent(self::InfoLogger, $reservation);
                } else {
                    $this->fireEvent(self::ErrorLogger, 'Error: reservation already exists');
                }
            } catch (\Exception $e) {
                $this->fireEvent(self::ErrorLogger, $e->getMessage());
            }
        }
    }

    /**
     * Save Entity Reservation
     * @param Reservation $reservation
     * @return void
     */
    private function saveEntity(Reservation $reservation): void
    {
        $reservationRepository = $this->entityManager->getRepository(Reservation::class);
        if (!$reservationRepository->findOneBy(['id' => $reservation->getId()])) {
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();
        }
    }
}
