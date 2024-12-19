<?php
declare(strict_types=1);


namespace App\Infrastructure\Persistence\Repository;


use App\Domain\Entity\AvailableDay;
use DateTimeImmutable;
use App\Domain\Repository\AvailabilityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;


readonly class AvailabilityRepository implements AvailabilityRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function getAvailabilityForDate(DateTimeImmutable $date): int
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        return (int) $queryBuilder
            ->select('availableDay.availableRooms')
            ->from(AvailableDay::class, 'availableDay')
            ->where('availableDay.date = :date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function reduceAvailability(DateTimeImmutable $date, int $rooms): void
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->update(AvailableDay::class, 'availableDay')
            ->set('availableDay.availableRooms', 'availableDay.availableRooms - :rooms')
            ->where('availableDay.date = :date')
            ->setParameter('rooms', $rooms)
            ->setParameter('date', $date);

        $queryBuilder->getQuery()->execute();
    }
}