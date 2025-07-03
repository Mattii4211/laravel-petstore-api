<?php
namespace App\Actions\Pet\Handlers;

use App\Actions\Pet\Commands\DeletePetCommand;
use App\Services\PetApiService;
use Exception;
use App\Data\Pets\Dto\SuccessDto;

class DeletePetHandler
{
    public function __construct(protected PetApiService $petApiService) {}

    public function handle(DeletePetCommand $command): bool
    {
        $response = $this->petApiService->delete($command->id);

        if (!$response instanceof SuccessDto) {
            throw new Exception($response->getMessage());
        }

        return true;
    }
}
