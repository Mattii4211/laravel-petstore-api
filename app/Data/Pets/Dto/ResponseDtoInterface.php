<?php

declare(strict_types=1);

namespace App\Data\Pets\Dto;

interface ResponseDtoInterface
{
    public function getMessage(): string;
}