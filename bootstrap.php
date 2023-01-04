<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/vendor/autoload.php';

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

(new App\DevCoder\DotEnv(__DIR__ . '/.env'))->load();

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src/Entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
// database configuration parameters
$conn = array(
    'driver' => getenv('PDO_DRIVER'),
    'host' => getenv('PDO_HOST'),
    'port' => getenv('PDO_PORT'),
    'dbname' => getenv('PDO_DBNAME'),
    'user' => getenv('PDO_USER'),
    'password' => getenv('PDO_PASSWORD'),
    'path' => getenv('PDO_PATH')
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
