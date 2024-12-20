<?php
declare(strict_types=1);


namespace App\Domain\Service;


use App\Domain\Entity\Booking;
use App\Domain\ValueObject\DateRange;

interface BookingCreator
{
    public function createBooking(DateRange $dateRange): Booking;
}