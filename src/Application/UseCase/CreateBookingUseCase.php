<?php
declare(strict_types=1);

namespace App\Application\UseCase;


use App\Application\DTO\CreateBookingDTO;
use App\Domain\Service\AvailabilityService;
use App\Domain\Service\BookingCreator;
use App\Domain\ValueObject\DateRange;
use DateTimeImmutable;
use DomainException;

readonly class CreateBookingUseCase
{
    public function __construct(
        private AvailabilityService $availabilityService,
        private BookingCreator      $bookingCreator
    ) {}

    public function execute(CreateBookingDTO $dto): void
    {
        $dateRange = new DateRange($dto->getStartDate(), $dto->getEndDate());

        if ($dateRange->getStartDate() < new DateTimeImmutable('now')) {
            throw new DomainException('Cannot book a past date.');
        }

        if(!$this->availabilityService->isAvailable($dateRange, $dto->getGuests())){
            throw new DomainException("Not enough rooms available.");
        }

        $this->bookingCreator->createBooking($dateRange);
        $this->availabilityService->reduceAvailability($dateRange, $dto->getGuests());
    }
}