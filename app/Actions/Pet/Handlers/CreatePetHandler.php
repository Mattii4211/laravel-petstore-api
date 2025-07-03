<?php
namespace App\Actions\Pet\Handlers;

use App\Actions\Pet\Commands\CreatePetCommand;
use App\Data\Pets\Dto\SuccessDto;
use App\Services\PetApiService;

class CreatePetHandler
{
    public function __construct(protected PetApiService $petApiService) {}

    public function handle(CreatePetCommand $command): bool
    {
        $response = $this->petApiService->create($command->data);

        if (!$response instanceof SuccessDto) {
            throw new \Exception($response->getMessage());
        }

        return true;
    }
}
