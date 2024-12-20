<?php
declare(strict_types=1);


namespace App\Domain\Factory;


use App\Domain\Entity\AvailableDay;
use App\Domain\Exception\BookingException;
use App\Domain\Specification\AvailableDaySpecification;
use DateTimeImmutable;

readonly class AvailableDayFactory
{
    public function __construct(
        private AvailableDaySpecification $specification
    ) {}

    /**
     * @throws BookingException
     */
    public function createAvailableDay(
        DateTimeImmutable $date,
        int $availableRooms,
    ): AvailableDay {
        $this->specification->isSatisfiedBy($date, $availableRooms);

        return new AvailableDay($date, $availableRooms);
    }
}