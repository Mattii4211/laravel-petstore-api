<?php

namespace App\Data\Pets\Dto;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;

final class EditPetDto extends Data {

    public function __construct(
        #[Required, StringType]
        public string $name,

        public array $photoUrls = [],

        public array $tags = [],

        public string $status = 'available',
    ) {}
}