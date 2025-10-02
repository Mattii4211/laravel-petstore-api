<?php

namespace App\Data\Pets\Dto;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

final class CreatePetDto extends Data
{
    /**
     * @param list<string> $photoUrls
     * @param list<TagDto>|null $tags
     */
    public function __construct(
        #[Required, StringType]
        public string $name,
        #[Required, StringType]
        public string $category,
        #[ArrayType]
        public array $photoUrls,

        /** @var TagDto[]|null */
        #[ArrayType, Nullable]
        public ?array $tags = null,
        #[StringType, Nullable]
        public ?string $status = null,
    ) {
    }
}
