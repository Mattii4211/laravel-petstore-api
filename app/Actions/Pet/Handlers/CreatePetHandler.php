<?php

namespace App\Actions\Pet\Handlers;

use App\Actions\Pet\Commands\CreatePetCommand;
use App\Data\Pets\Dto\SuccessDto;
use App\Services\PetApiService;
use Exception;

class CreatePetHandler
{
    public function __construct(protected PetApiService $petApiService)
    {
    }

    public function handle(CreatePetCommand $command): bool
    {
        $data = [
            'id' => time() + rand(1, 1000),
            'name' => $command->data->name,
            'category' => [
                'id' => time(),
                'name' => $command->data->category,
            ],
            'photoUrls' => $command->data->photoUrls,
            'tags' => array_map(fn ($tag) => ['id' => time(), 'name' => $tag->name], $command->data->tags),
            'status' => $command->data->status ?? 'available',
        ];

        $response = $this->petApiService->create($data);

        if (! $response instanceof SuccessDto) {
            throw new Exception($response->getMessage());
        }

        return true;
    }
}
