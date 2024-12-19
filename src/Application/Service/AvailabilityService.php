<?php
declare(strict_types=1);


namespace App\Application\Service;


use App\Domain\Repository\AvailabilityRepositoryInterface;
use App\Domain\Service\AvailabilityService as AvailabilityServiceInterface;
use App\Domain\ValueObject\DateRange;

readonly class AvailabilityService implements AvailabilityServiceInterface
{
    public function __construct(
        private AvailabilityRepositoryInterface $availabilityRepository
    ) {}

    public function isAvailable(DateRange $dateRange, int $guests): bool
    {
        foreach ($dateRange->getDays() as $day) {
            $availableRooms = $this->availabilityRepository->getAvailabilityForDate($day);

            if ($availableRooms < $guests) {
                return false;
            }
        }

        return true;
    }

    public function reduceAvailability(DateRange $dateRange, int $roomCount): void
    {
        foreach ($dateRange->getDays() as $day) {
            $this->availabilityRepository->reduceAvailability($day, $roomCount);
        }
    }
}