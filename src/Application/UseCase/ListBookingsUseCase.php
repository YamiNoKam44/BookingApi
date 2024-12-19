<?php
declare(strict_types=1);


namespace App\Application\UseCase;


use App\Domain\Repository\BookingRepositoryInterface;
use App\Domain\ValueObject\DateRange;

readonly class ListBookingsUseCase
{
    public function __construct(
        private BookingRepositoryInterface $bookingRepository
    ) {}

    public function execute(DateRange $dateRange): array
    {
        $bookings = $this->bookingRepository->findByDateRange($dateRange);

        return array_map(static fn($booking) => $booking->toDTO(), $bookings);
    }
}