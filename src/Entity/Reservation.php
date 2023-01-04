<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Reservation
 *
 * @ORM\Entity
 * @ORM\Table(name="reservation")
 * @package App\Entity
 */
class Reservation
{

    /**
     * ID reservation
     * @ORM\Id
     * @ORM\Column(type="string")
     * @var string
     */
    private $id;

    /**
     * Title reservation
     * @ORM\Column(type="string")
     * @var string
     */
    private $title;

    /**
     * Pax
     * @ORM\Column(type="integer")
     * @var int
     */
    private $pax;

    /**
     * Total
     * @ORM\Column(type="float")
     * @var float
     */
    private $total;

    /**
     * Date
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $date;

    /**
     * Link
     * @ORM\Column(type="string")
     * @var string
     */
    private $link;

    /**
     * Constructor Reservation
     * @param string|null $title
     * @param int|null $pax
     * @param float|null $total
     * @param string|null $date
     * @param string|null $link
     * @throws \Exception
     */
    public function __construct(?string $title, ?int $pax, ?float $total, ?string $date, ?string $link)
    {
        $this->title = $title;
        $this->pax = $pax;
        $this->total = $total;
        $this->date = new \DateTime($date);
        $this->link = $link;
        $this->id = str_replace('Reservation ', '', $title);
        $error = $this->checkEntityCorrect();
        if (!is_null($error)) {
            throw new \Exception($error);
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPax(): int
    {
        return $this->pax;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setPax(int $pax): void
    {
        $this->pax = $pax;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }
    
    public function getTotalFormat(): string
    {
        return sprintf('%0.2f €', $this->total);
    }

    /**
     * Parse to string reservation
     * @return string
     */
    public function __toString()
    {
        $message = 'id: ' . $this->id . PHP_EOL . "\t"
            . 'title: ' . $this->title . PHP_EOL . "\t"
            . 'pax: ' . $this->pax . PHP_EOL . "\t"
            . 'total: ' . $this->getTotalFormat() . PHP_EOL . "\t"
            . 'date: ' . $this->date->format('Y-m-d H:i:s') . PHP_EOL . "\t"
            . 'link: ' . $this->link;

        return $message;
    }

    /**
     * Check if reservation is correct
     * @return string|null
     */
    private function checkEntityCorrect(): ?string
    {
        $error = [];
        if (is_null($this->id) || empty($this->id)) {
            $error[] = 'id is empty';
        }
        if (is_null($this->title) || empty($this->title)) {
            $error[] = (count($error) > 0 ? PHP_EOL . "\t" : '') . 'title is empty';
        }
        if (is_null($this->pax) || empty($this->pax)) {
            $error[] = (count($error) > 0 ? PHP_EOL . "\t" : '') . 'pax is empty';
        }
        if (is_null($this->total) || empty($this->total)) {
            $error[] = (count($error) > 0 ? PHP_EOL . "\t" : '') . 'total is empty';
        }
        if (is_null($this->date) || empty($this->date)) {
            $error[] = (count($error) > 0 ? PHP_EOL . "\t" : '') . 'date is empty';
        }
        if (is_null($this->link) || empty($this->link)) {
            $error[] = (count($error) > 0 ? PHP_EOL . "\t" : '') . 'link is empty';
        }

        return count($error) > 0 ? implode('', $error) : null;
    }
}
