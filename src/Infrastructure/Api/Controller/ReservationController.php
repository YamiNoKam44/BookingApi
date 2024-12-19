<?php
declare(strict_types=1);


namespace App\Infrastructure\Api\Controller;


use App\Application\UseCase\ListBookingsUseCase;
use App\Domain\ValueObject\DateRange;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{
    public function __construct(
        private readonly ListBookingsUseCase $listBookingsUseCase
    ) {}

    #[Route('/api/reservation/list', methods: [Request::METHOD_GET])]
    public function __invoke(Request $request): JsonResponse
    {
        $startDate = new DateTimeImmutable($request->query->get('startDate', 'now'));
        $endDate = new DateTimeImmutable($request->query->get('endDate', '+1 month'));

        $dateRange = new DateRange($startDate, $endDate);

        $bookings = $this->listBookingsUseCase->execute($dateRange);

        return $this->json(['data' => $bookings]);
    }
}