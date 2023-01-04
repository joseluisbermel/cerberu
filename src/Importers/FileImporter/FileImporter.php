<?php
namespace App\Importers\FileImporter;

use App\Importers\FileImporter\Elements\ElementInterface;

/**
 * Class FileImporter
 *
 * @package App\Importers\FileImporter
 */
abstract class FileImporter
{

    /**
     * file name
     * @var string
     */
    protected $file;

    /**
     * list elements
     * @var ElementInterface
     */
    protected $elements;

    /**
     * load file
     * @param string $file
     * @throws \Exception
     */
    public function __construct(string $file)
    {
        $this->file = $file;
        if (!file_exists($this->file)) {
            throw new \Exception($this->file . ' does not exists in the selected path');
        }
        if (!filesize($this->file)) {
            throw new \Exception($this->file . ' is empty');
        }
    }

    /**
     * Get Elements
     * @return ElementInterface
     */
    public function getElements(): ElementInterface
    {
        return $this->elements;
    }

    abstract function load(): void;
}
