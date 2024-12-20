<?php
declare(strict_types=1);


namespace App\Application\Service;


use App\Domain\Entity\Booking;
use App\Domain\Entity\BookingDay;
use App\Domain\Repository\AvailabilityRepositoryInterface;
use App\Domain\Repository\BookingRepositoryInterface;
use App\Domain\Service\BookingCreator as BookingCreatorInterface;
use App\Domain\ValueObject\DateRange;
use DateMalformedStringException;

readonly class BookingCreator implements BookingCreatorInterface
{
    public function __construct(
        private BookingRepositoryInterface $bookingRepository
    ) {}

    /**
     * @throws DateMalformedStringException
     */
    public function createBooking(DateRange $dateRange): Booking
    {
        $booking = new Booking($dateRange);

        foreach ($dateRange->getDays() as $day) {
            $booking->bookDay($day);
        }

        $this->bookingRepository->save($booking);

        return $booking;
    }
}