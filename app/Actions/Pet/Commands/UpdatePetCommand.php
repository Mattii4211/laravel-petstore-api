<?php

namespace App\Actions\Pet\Commands;

use App\Data\Pets\Dto\EditPetDto;

class UpdatePetCommand
{
    public function __construct(
        public int $id,
        public EditPetDto $data
    ) {
    }
}
