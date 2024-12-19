<?php
declare(strict_types=1);


namespace App\Domain\Repository;


use App\Domain\Entity\Booking;
use App\Domain\ValueObject\DateRange;

interface BookingRepositoryInterface
{
    public function findByDateRange(DateRange $dateRange): array;

    public function save(Booking $booking): void;
}