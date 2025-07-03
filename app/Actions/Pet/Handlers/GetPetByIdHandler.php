<?php
namespace App\Actions\Pet\Handlers;

use App\Actions\Pet\Queries\GetPetByIdQuery;
use App\Services\PetApiService;

class GetPetByIdHandler
{
    public function __construct(protected PetApiService $petApiService) {}

    public function handle(GetPetByIdQuery $query): ?array
    {
        return $this->petApiService->findById($query->id);
    }
}
