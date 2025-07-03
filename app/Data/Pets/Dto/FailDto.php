<?php

declare(strict_types=1);

namespace App\Data\Pets\Dto;

final class FailDto implements ResponseDtoInterface
{
    public function __construct(
        public int $code,
        public string $errorMessage
    ) {}

    public function getMessage(): string
    {
        return $this->errorMessage;
    }
}