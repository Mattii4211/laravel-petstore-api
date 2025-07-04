<?php

declare(strict_types=1);

namespace App\Data\Pets\Dto;

final class SuccessDto implements ResponseDtoInterface
{
    public function __construct(
        public int $code,
        public string $message
    ) {}

    public function getMessage(): string
    {
        return $this->message;
    }
}
