<?php
namespace App\Importers\FileImporter;

use App\Importers\FileImporter\Elements\ArrayObject;

/**
 * Class JsonImporter
 *
 * @package App\Importers\FileImporter
 */
class JsonImporter extends FileImporter
{

    public function load(): void
    {
        $file = file_get_contents($this->file);
        $jsonDecode = json_decode($file, false);
        if(!is_array($jsonDecode) || count($jsonDecode) == 0) {
            throw new \Exception($this->file . ' is empty');
        }
        $this->elements = new ArrayObject(json_decode($file, false));
    }
}
