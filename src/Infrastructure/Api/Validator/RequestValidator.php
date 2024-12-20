<?php
declare(strict_types=1);


namespace App\Infrastructure\Api\Validator;


use InvalidArgumentException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestValidator
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    ) {}

    public function validateAndDeserialize(string $content, string $type): array
    {
        $dtoCollection = $this->serializer->deserialize($content, $type, 'json');

        foreach ($dtoCollection as $dto) {
            $errors = $this->validator->validate($dto);
            if (count($errors) > 0) {
                throw new InvalidArgumentException((string)$errors);
            }
        }

        return $dtoCollection;
    }
}