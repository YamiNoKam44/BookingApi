<?php
declare(strict_types=1);


namespace App\Domain\Entity;


use App\Domain\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'available_day')]
class AvailableDay
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;
    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $date;

    #[ORM\Column(type: 'integer')]
    private int $availableRooms;

    public function __construct(
        DateTimeImmutable $date,
        int $availableRooms,
    ) {
        $this->id = Id::generate()->getValue();
        $this->date = $date;
        $this->availableRooms = $availableRooms;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getAvailableRooms(): int
    {
        return $this->availableRooms;
    }
}