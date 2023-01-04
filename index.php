<?php
require_once __DIR__ . '/bootstrap.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

$week = $_POST['week'];

$reservarionService = new \App\Service\ReservationService($entityManager);

list('reservations' => $list, 'summary' => $summary, 'weeks' => $weeks) = $reservarionService->findAllByWeek($week);

echo $twig->render('index.html.twig', ['reservations' => $list, 'summary' => $summary, 'weeks' => $weeks, 'week' => $week]);
