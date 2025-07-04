<?php

namespace App\Data\Pets\Dto;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

final class CategoryDto extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $id,
        #[Required, StringType]
        public string $name,
    ) {
    }
}
