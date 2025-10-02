<?php

namespace App\Actions\Pet\Handlers;

use App\Actions\Pet\Queries\GetPetsQuery;
use App\Services\PetApiService;

class GetPetsHandler
{
    public function __construct(protected PetApiService $petApiService)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function handle(GetPetsQuery $query): array
    {
        return $this->petApiService->findByStatus($query->status);
    }
}
