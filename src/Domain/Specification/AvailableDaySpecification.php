<?php
declare(strict_types=1);


namespace App\Domain\Specification;

use App\Domain\Exception\BookingException;
use DateTimeImmutable;

class AvailableDaySpecification
{
    /**
     * @throws BookingException
     */
    public function isSatisfiedBy(
        DateTimeImmutable $date,
        int $availableRooms,
    ): bool {
        if ($availableRooms < 0) {
            throw new BookingException('Liczba pokoi nie może być ujemna');
        }

        if ($date < new DateTimeImmutable('today')) {
            throw new BookingException('Nie można utworzyć dostępnego dnia w przeszłości');
        }

        return true;
    }
}