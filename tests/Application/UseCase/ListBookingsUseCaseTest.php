<?php
declare(strict_types=1);


namespace App\Tests\Application\UseCase;

use App\Application\UseCase\ListBookingsUseCase;
use App\Domain\Repository\BookingRepositoryInterface;
use App\Domain\ValueObject\DateRange;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ListBookingsUseCaseTest extends TestCase
{
    private BookingRepositoryInterface|MockObject $bookingRepository;
    protected function setUp(): void
    {
        $this->bookingRepository = $this->createMock(BookingRepositoryInterface::class);
    }

    public function testIsClassInstanceAble(): void
    {
        $this->assertInstanceOf(ListBookingsUseCase::class, new ListBookingsUseCase($this->bookingRepository));
    }

    public function testExecute(): void
    {
        $dateRange = new DateRange(new \DateTimeImmutable('2024-01-01'), new \DateTimeImmutable('2024-01-31'));

        $this->bookingRepository->expects($this->once())
            ->method('findByDateRange')
            ->with($dateRange)
            ->willReturn([]);

        $useCase = new ListBookingsUseCase($this->bookingRepository);
        $result = $useCase->execute($dateRange);

        $this->assertSame([], $result);
    }
}