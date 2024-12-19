<?php
declare(strict_types=1);


namespace App\Domain\ValueObject;

use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
readonly class DateRange
{
    public function __construct(
        #[ORM\Column(type: 'datetime_immutable')]
        private DateTimeInterface $startDate = new DateTimeImmutable(),
        #[ORM\Column(type: 'datetime_immutable')]
        private DateTimeInterface $endDate = new DateTimeImmutable(),
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->startDate >= $this->endDate) {
            throw new InvalidArgumentException('Start date must be before end date');
        }
    }

    public function getStartDate(): DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTimeInterface
    {
        return $this->endDate;
    }

    public function getDurationInDays(): int
    {
        return $this->endDate->diff($this->startDate)->days;
    }

    public function overlaps(DateRange $other): bool
    {
        return $this->startDate < $other->getEndDate()
            && $this->endDate > $other->getStartDate();
    }

    public function includes(DateTimeInterface $date): bool
    {
        return $date >= $this->startDate && $date <= $this->endDate;
    }


    /**
     * @return DateTimeImmutable[]
     */
    public function getDays(): array
    {
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($this->startDate, $interval, $this->endDate->add($interval));

        $days = [];
        foreach ($period as $date) {
            $days[] = $date;
        }

        return $days;
    }

    public static function create(
        DateTimeInterface $startDate,
        DateTimeInterface $endDate
    ): self {
        return new self($startDate, $endDate);
    }
}