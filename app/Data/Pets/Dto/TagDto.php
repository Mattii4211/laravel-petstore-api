<?php

namespace App\Data\Pets\Dto;

use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

final class TagDto extends Data
{
    public function __construct(
        #[StringType, Nullable]
        public ?string $name,
    ) {
    }
}
