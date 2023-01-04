<?php
namespace App\Importers\FileImporter\Elements;

/**
 * Class ArrayObject
 *
 * @package App\Importers\FileImporter\Elements
 */
class ArrayObject implements ElementInterface
{

    /**
     * Elements
     * @var array
     */
    public $elements;

    /**
     * Construct
     * @param array $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }
}
