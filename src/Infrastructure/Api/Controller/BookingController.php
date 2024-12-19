<?php
declare(strict_types=1);


namespace App\Infrastructure\Api\Controller;


use App\Application\DTO\CreateBookingDTO;
use App\Application\UseCase\CreateBookingUseCase;
use App\Infrastructure\Api\Validator\RequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookingController extends AbstractController
{
    public function __construct(
        private readonly CreateBookingUseCase $createBookingUseCase,
        private readonly RequestValidator $requestValidator
    ) {}

    #[Route('/api/booking', methods: [Request::METHOD_POST])]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $bookingDTOs = $this->requestValidator->validateAndDeserialize(
                $request->getContent(),
                CreateBookingDTO::class
            );

            foreach ($bookingDTOs as $bookingDTO) {
                $this->createBookingUseCase->execute($bookingDTO);
            }
        } catch (\Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['status' => 'ok'], Response::HTTP_CREATED);
    }
}