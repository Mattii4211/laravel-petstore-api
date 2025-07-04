<?php

namespace App\Actions\Pet\Enum;

use InvalidArgumentException;

enum Status: string
{
    case AVAILABLE = 'available';
    case PENDING = 'pending';
    case SOLD = 'sold';

    public static function fromString(string $value): self
    {
        return match ($value) {
            'available' => self::AVAILABLE,
            'pending' => self::PENDING,
            'sold' => self::SOLD,
            default => throw new InvalidArgumentException("Invalid status: $value"),
        };
    }
}
