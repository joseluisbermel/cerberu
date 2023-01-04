<?php

require __DIR__ . '/bootstrap.php';

/**
 * You can start writing code here. Please DO NOT CHANGE ANY SKELETON CLASSES.
 * You can create as many files, folders and classes as you need.
 *
 * You might notice that we are using Composer.
 */
$importer = new \App\Importers\DataImporter(__DIR__, $entityManager);
$importer->import();