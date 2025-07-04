<?php

namespace App\Actions\Pet\Handlers;

use App\Actions\Pet\Commands\UpdatePetCommand;
use App\Actions\Pet\Enum\Status;
use App\Data\Pets\Dto\SuccessDto;
use App\Services\PetApiService;
use Exception;
use InvalidArgumentException;

class UpdatePetHandler
{
    public function __construct(protected PetApiService $petApiService)
    {
    }

    public function handle(UpdatePetCommand $command): bool
    {
        $pet = $this->petApiService->findById($command->id);
        if (! $pet) {
            throw new Exception("Pet with ID {$command->id} not found.");
        }

        try {
            $status = Status::fromString($command->data->status);
        } catch (InvalidArgumentException $e) {
            $status = Status::AVAILABLE;
        }

        $data = [
            'id' => $pet['id'],
            'name' => $command->data->name,
            'status' => $status->value,
            'photoUrls' => $command->data->photoUrls,
            'tags' => array_map(fn ($tag) => ['id' => time(), 'name' => $tag->name], $command->data->tags),
        ];

        if ($command->data->category) {
            $data['category'] = [
                'id' => $pet['category']['id'] ?? time(),
                'name' => $command->data->category,
            ];
        }

        $response = $this->petApiService->update($data);

        if (! $response instanceof SuccessDto) {
            throw new Exception($response->getMessage());
        }

        return true;
    }
}
