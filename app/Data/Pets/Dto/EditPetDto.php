<?php

namespace App\Data\Pets\Dto;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

final class EditPetDto extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $name,
        #[Required, StringType]
        public string $status,
        #[StringType, Nullable]
        public ?string $category,
        #[ArrayType]
        public array $photoUrls,

        /** @var TagDto[]|null */
        #[ArrayType, Nullable]
        public ?array $tags = null,
    ) {
    }
}
