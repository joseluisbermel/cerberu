<?php
namespace App\Importers\FileImporter;

use App\Importers\FileImporter\Elements\XmlObject;

/**
 * Class XmlImporter
 *
 * @package App\Importers\FileImporter
 */
class XmlImporter extends FileImporter
{

    public function load(): void
    {
        $simpleXMLElement = simplexml_load_file($this->file);
        if (!$simpleXMLElement || $simpleXMLElement->count() == 0) {
            throw new \Exception($this->file . ' is empty');
        }
        $this->elements = new XmlObject($simpleXMLElement);
    }
}
