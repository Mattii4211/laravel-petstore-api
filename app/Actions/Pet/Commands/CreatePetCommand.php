<?php

namespace App\Actions\Pet\Commands;

class CreatePetCommand
{
    public function __construct(
        public array $data
    ) {}
}
