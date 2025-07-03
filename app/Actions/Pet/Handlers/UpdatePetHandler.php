<?php
namespace App\Actions\Pet\Handlers;

use App\Actions\Pet\Commands\UpdatePetCommand;
use App\Data\Pets\Dto\SuccessDto;
use App\Services\PetApiService;
use Exception;

class UpdatePetHandler
{
    public function __construct(protected PetApiService $petApiService) {}

    public function handle(UpdatePetCommand $command): bool
    {
        $response = $this->petApiService->update([
            'id' => $command->id,
            'name' => $command->data->name,
        ]);

        if (!$response instanceof SuccessDto) {
            throw new Exception($response->getMessage());
        }
       
        return true;
    }
}
