<?php
declare(strict_types=1);

namespace App\Application\DTO\Response;

use App\Domain\Entity\Booking;

final class BookingResponseDTO
{
    public function __construct(
        public string $id,
        public string $startDate,
        public string $endDate,
    ) {}

    public static function fromDomain(Booking $booking): self
    {
        $dataRange = $booking->getDateRange();
        return new self(
            $booking->getId(),
            $dataRange->getStartDate()->format('Y-m-d'),
            $dataRange->getEndDate()->format('Y-m-d'),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];
    }
}