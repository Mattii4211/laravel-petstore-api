<?php

namespace App\Data\Pets\Dto;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;

final class PetDto extends Data
{
    public function __construct(
        #[Required]
        public int $id,
        #[Required, StringType]
        public string $name,
        #[StringType, Nullable]
        public ?string $status,
        /** @var string[] */
        #[ArrayType]
        public array $photoUrls,
        /** @var TagDto[]|null */
        #[ArrayType, Nullable]
        public ?array $tags = null,
        /** @var array<string, mixed>|null */
        #[ArrayType, Nullable]
        public ?array $category = null,
    ) {}
}
