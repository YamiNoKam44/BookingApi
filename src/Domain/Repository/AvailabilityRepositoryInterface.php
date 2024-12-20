<?php
declare(strict_types=1);


namespace App\Domain\Repository;


use App\Domain\ValueObject\DateRange;
use DateTimeImmutable;

interface AvailabilityRepositoryInterface
{
    public function getAvailabilityForDate(DateTimeImmutable $date): int;

    public function reduceAvailability(DateTimeImmutable $date, int $rooms): void;
}