<?php

namespace App\Actions\Pet\Handlers;

use App\Actions\Pet\Queries\GetPetByIdQuery;
use App\Data\Pets\Dto\PetDto;
use App\Services\PetApiService;

class GetPetByIdHandler
{
    public function __construct(protected PetApiService $petApiService)
    {
    }

    public function handle(GetPetByIdQuery $query): ?PetDto
    {
        return $this->petApiService->findById($query->id);
    }
}
