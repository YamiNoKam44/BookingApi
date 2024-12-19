<?php
declare(strict_types=1);


namespace App\Domain\Entity;


use App\Domain\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity]
#[ORM\Table(name: 'booking_day')]
class BookingDay
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;

    #[ORM\Column(type: 'date_immutable')]
    private \DateTimeImmutable $date;

    #[ORM\ManyToOne(targetEntity: Booking::class, inversedBy: 'bookedDays')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private Booking $booking;

    public function __construct(DateTimeImmutable $date, Booking $booking)
    {
        $this->id = Id::generate()->getValue();
        $this->date = $date;
        $this->booking = $booking;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getBooking(): Booking
    {
        return $this->booking;
    }
}