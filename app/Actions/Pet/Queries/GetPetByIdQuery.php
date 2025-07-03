<?php

namespace App\Actions\Pet\Queries;

class GetPetByIdQuery
{
    public function __construct(public int $id) {}
}
