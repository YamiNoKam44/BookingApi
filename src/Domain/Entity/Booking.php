<?php
declare(strict_types=1);


namespace App\Domain\Entity;


use App\Domain\ValueObject\DateRange;
use App\Domain\ValueObject\Id;
use DateMalformedStringException;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
#[ORM\Table(name: 'booking')]
class Booking
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;

    #[ORM\Embedded(class: DateRange::class)]
    private DateRange $dateRange;

    #[ORM\OneToMany(targetEntity: BookingDay::class, mappedBy: 'booking', cascade: ['persist'], orphanRemoval: true)]
    private Collection $bookedDays;

    /**
     * @throws DateMalformedStringException
     */
    public function __construct(
        DateRange $dateRange,
    ) {
        $this->id = Id::generate()->getValue();
        $this->dateRange = $dateRange;
        $this->bookedDays = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDateRange(): DateRange
    {
        return $this->dateRange;
    }


    public function bookDay(DateTimeImmutable $day): void
    {
        foreach ($this->bookedDays as $existingDay) {
            if ($existingDay->getDate() == $day) {
                throw new DomainException('Day is already booked.');
            }
        }
        $this->bookedDays->add(new BookingDay($day, $this));
    }

}
