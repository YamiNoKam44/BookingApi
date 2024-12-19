<?php
declare(strict_types=1);


namespace App\Application\DTO;


use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateBookingDTO
{

    private function __construct(
        #[Assert\NotNull]
        #[Assert\Type(DateTimeImmutable::class)]
        private DateTimeImmutable $startDate,
        #[Assert\NotNull]
        #[Assert\Type(DateTimeImmutable::class)]
        #[Assert\GreaterThan(propertyPath: 'startDate')]
        private DateTimeImmutable $endDate,
        #[Assert\NotBlank]
        #[Assert\Positive]
        private int               $guests
    ) {
        if ($this->startDate > $this->endDate) {
            throw new InvalidArgumentException('Start date cannot be after end date.');
        }
    }

    public static function create(
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        int $guests
    ): self {
        return new self($startDate, $endDate, $guests);
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getGuests(): int
    {
        return $this->guests;
    }
}
