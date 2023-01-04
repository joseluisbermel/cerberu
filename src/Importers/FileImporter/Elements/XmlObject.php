<?php
namespace App\Importers\FileImporter\Elements;

/**
 * Class XmlObject
 *
 * @package App\Importers\FileImporter\Elements
 */
class XmlObject implements ElementInterface
{

    /**
     * Elements
     * @var \SimpleXMLElement
     */
    public $elements;

    /**
     * Constructor
     * @param \SimpleXMLElement $elements
     */
    public function __construct(\SimpleXMLElement $elements)
    {
        $this->elements = $elements;
    }
}
