<?php
declare(strict_types=1);


namespace App\Infrastructure\Persistence\Fixtures;


use App\Domain\Factory\AvailableDayFactory;
use DateMalformedStringException;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AvailableDayFixtures extends Fixture
{
    public function __construct(
        private readonly AvailableDayFactory $availableDayFactory
    ) {}

    /**
     * @throws DateMalformedStringException
     */
    public function load(ObjectManager $manager): void
    {
        $startDate = new DateTimeImmutable('today');

        for ($index = 0; $index < 30; $index++) {
            $currentDate = $startDate->modify(sprintf("+%d days", $index));

            $availableDay = $this->availableDayFactory->createAvailableDay(
                $currentDate,
                10
            );

            $manager->persist($availableDay);
        }

        $manager->flush();
    }
}