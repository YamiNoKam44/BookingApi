<?php
declare(strict_types=1);


namespace App\Infrastructure\Persistence\Repository;


use App\Domain\Entity\Booking;
use App\Domain\Repository\BookingRepositoryInterface;
use App\Domain\ValueObject\DateRange;
use Doctrine\ORM\EntityManagerInterface;

readonly class BookingRepository implements BookingRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function findByDateRange(DateRange $dateRange): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        return $queryBuilder
            ->select('booking')
            ->from(Booking::class, 'booking')
            ->where('booking.dateRange.startDate <= :endDate')
            ->andWhere('booking.dateRange.endDate >= :startDate')
            ->setParameter('startDate', $dateRange->getStartDate())
            ->setParameter('endDate', $dateRange->getEndDate())
            ->getQuery()
            ->getResult();
    }

    public function save(Booking $booking): void
    {
        $entityManager = $this->entityManager;
        $entityManager->persist($booking);
        $entityManager->flush();
    }
}