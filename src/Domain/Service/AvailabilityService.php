<?php
declare(strict_types=1);


namespace App\Domain\Service;


use App\Domain\ValueObject\DateRange;

interface AvailabilityService
{
    public function isAvailable(DateRange $dateRange, int $guests): bool;
    public function reduceAvailability(DateRange $dateRange, int $roomCount): void;
}