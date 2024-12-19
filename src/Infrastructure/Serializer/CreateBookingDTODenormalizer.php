<?php
declare(strict_types=1);

namespace App\Infrastructure\Serializer;

use App\Application\DTO\CreateBookingDTO;
use DateMalformedStringException;
use DateTimeImmutable;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CreateBookingDTODenormalizer implements DenormalizerInterface
{
    /**
     * @throws DateMalformedStringException
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): array
    {
        if (!array_key_exists('data', $data)) {
            $data['data'] = [];
        }

        $result = [];
        foreach ($data['data'] as $bookingData) {
            $result[] = CreateBookingDTO::create(
                new DateTimeImmutable($bookingData['startDate'] ?? 'now'),
                new DateTimeImmutable($bookingData['endDate'] ?? 'now'),
                $bookingData['guests'] ?? 1
            );
        }

        return $result;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            CreateBookingDTO::class => true
            ];
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === CreateBookingDTO::class;
    }
}