<?php

namespace App\Actions\Pet\Queries;

class GetPetsQuery
{
    public function __construct(public string $status = 'available')
    {
    }
}
