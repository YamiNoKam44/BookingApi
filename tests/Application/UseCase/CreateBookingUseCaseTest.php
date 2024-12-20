<?php
declare(strict_types=1);


namespace App\Tests\Application\UseCase;


use App\Application\DTO\CreateBookingDTO;
use App\Application\UseCase\CreateBookingUseCase;
use App\Domain\Service\AvailabilityService;
use App\Domain\Service\BookingCreator;
use DateTimeImmutable;
use DomainException;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateBookingUseCaseTest extends TestCase
{
    private AvailabilityService|MockObject $availabilityService;
    private BookingCreator|MockObject $bookingCreator;
    protected function setUp(): void
    {
        $this->availabilityService = $this->createMock(AvailabilityService::class);
        $this->bookingCreator = $this->createMock(BookingCreator::class);
    }

    public function testIsClassInstanceAble(): void
    {
        $this->assertInstanceOf(CreateBookingUseCase::class,
            new CreateBookingUseCase($this->availabilityService, $this->bookingCreator));
    }

    #[DataProvider('exceptionDataProvider')]
    public function testWillThrowException(DateTimeImmutable $startDate, DateTimeImmutable $endDate,
                                           string $exceptionClass, string $exceptionMessage): void
    {
        var_dump($exceptionClass, $exceptionMessage, $startDate, $endDate);
        $useCase = new CreateBookingUseCase($this->availabilityService, $this->bookingCreator);

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $useCase->execute(CreateBookingDTO::create($startDate, $endDate, 1));
    }

    public function testPassSuccessful(): void
    {
        $this->availabilityService
            ->expects($this->once())
            ->method('isAvailable')
            ->willReturn(true);
        $useCase = new CreateBookingUseCase($this->availabilityService, $this->bookingCreator);

        $prepareData = (new DateTimeImmutable())->modify('+1 day');
        $prepareEndData = (new DateTimeImmutable())->modify('+2 days');

        $useCase->execute(CreateBookingDTO::create($prepareData, $prepareEndData, 1));
    }

    public static function exceptionDataProvider(): array
    {
        $dayPlusOne = new DateTimeImmutable()->modify('+1 day');
        $dayPlusTwo = new DateTimeImmutable()->modify('+2 day');
        return [
            [
                new DateTimeImmutable(),
                new DateTimeImmutable(),
                DomainException::class,
                "Cannot book a past date."
            ],
            [
                $dayPlusOne,
                $dayPlusOne,
                InvalidArgumentException::class,
                "Start date must be before end date"
            ],
            [
                $dayPlusOne,
                $dayPlusTwo,
                DomainException::class,
                "Not enough rooms available."
            ]
        ];
    }

}