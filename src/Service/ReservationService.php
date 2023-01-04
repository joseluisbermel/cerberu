<?php
namespace App\Service;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManager;

/**
 * Class ReservationService
 *
 * @package App\Service
 */
class ReservationService
{

    /**
     * Entity Manager
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Constructor
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Find All By Week
     * @param string|null $week
     * @return array
     */
    public function findAllByWeek(?string $week = null): array
    {
        $reservationRepository = $this->entityManager->getRepository(Reservation::class);
        if (isset($week)) {
            $dateMonday = new \DateTime($week);
            $dateSunday = new \DateTime($week);
            $dateMonday->modify('last Monday');
            $dateSunday->modify('next Sunday');
            $qb = $reservationRepository->createQueryBuilder('r');
            $qb->andWhere("r.date BETWEEN '{$dateMonday->format('Y-m-d 00:00:00')}' AND '{$dateSunday->format('Y-m-d 23:59:59')}'");
            $reservations = $qb->getQuery()->getResult();
            $reservationsTotal = $reservationRepository->findAll();
        } else {
            $reservations = $reservationRepository->findAll();
            $reservationsTotal = $reservations;
        }

        return [
            'reservations' => $this->formaterDTO($reservations),
            'summary' => $this->getSummary($reservations),
            'weeks' => $this->getWeeks($reservationsTotal)
        ];
    }

    /**
     * Formater DTO
     * @param array $reservations
     * @return array
     */
    public function formaterDTO(array $reservations): array
    {
        return array_map(function (Reservation $reservation) {
            return [
            'id' => $reservation->getId(),
            'title' => $reservation->getTitle(),
            'pax' => $reservation->getPax(),
            'total' => $reservation->getTotalFormat(),
            'date' => $reservation->getDate()->format('Y-m-d H:i:s'),
            'link' => $reservation->getLink()
            ];
        }, $reservations);
    }

    /**
     * Get Summary
     * @param array $reservations
     * @return array
     */
    public function getSummary(array $reservations): array
    {
        $summary = [
            'pax' => [
                'min' => 0,
                'avg' => 0,
                'max' => 0
            ],
            'total' => [
                'min' => 0,
                'avg' => 0,
                'max' => 0
            ]
        ];
        foreach ($reservations as $reservation) {
            if ($summary['pax']['min'] == 0 || $summary['pax']['min'] > $reservation->getPax()) {
                $summary['pax']['min'] = $reservation->getPax();
            }
            if ($summary['total']['min'] == 0 || $summary['total']['min'] > $reservation->getTotal()) {
                $summary['total']['min'] = $reservation->getTotal();
            }
            if ($summary['pax']['max'] < $reservation->getPax()) {
                $summary['pax']['max'] = $reservation->getPax();
            }
            if ($summary['total']['max'] < $reservation->getTotal()) {
                $summary['total']['max'] = $reservation->getTotal();
            }
            $summary['pax']['avg'] += $reservation->getPax();
            $summary['total']['avg'] += $reservation->getTotal();
        }

        if (count($reservations) > 0) {
            $summary['pax']['avg'] = round($summary['pax']['avg'] / count($reservations), 2);
            $summary['total']['avg'] = round($summary['total']['avg'] / count($reservations), 2);
        }

        return $summary;
    }

    /**
     * Get Weeks
     * @param array $reservations
     * @return array
     */
    public function getWeeks(array $reservations): array
    {
        $weeks = [];
        foreach ($reservations as $reservation) {
            if (!in_array($reservation->getDate()->format('Y-\WW'), $weeks)) {
                $weeks[] = $reservation->getDate()->format('Y-\WW');
            }
        }

        return $weeks;
    }
}
