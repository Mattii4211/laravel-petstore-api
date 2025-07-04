<?php

namespace App\Actions\Pet\Commands;

use App\Data\Pets\Dto\CreatePetDto;

class CreatePetCommand
{
    public function __construct(
        public CreatePetDto $data
    ) {}
}
