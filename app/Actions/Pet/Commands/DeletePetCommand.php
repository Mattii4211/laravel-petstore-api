<?php

namespace App\Actions\Pet\Commands;

class DeletePetCommand
{
    public function __construct(public int $id)
    {
    }
}
