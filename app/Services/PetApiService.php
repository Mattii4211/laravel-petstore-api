<?php

namespace App\Services;

use App\Data\Pets\Dto\FailDto;
use App\Data\Pets\Dto\ResponseDtoInterface;
use App\Data\Pets\Dto\SuccessDto;
use Illuminate\Support\Facades\Http;

class PetApiService
{
    protected string $baseUrl = 'https://petstore.swagger.io/v2';

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findByStatus(string $status): array
    {
        $response = Http::get("{$this->baseUrl}/pet/findByStatus", ['status' => $status]);

        if (! $response->successful()) {
            return [];
        }

        $pets = $response->json();

        usort($pets, fn ($a, $b) => ($a['id'] ?? 0) <=> ($b['id'] ?? 0));

        return $pets;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findById(int $id): ?array
    {
        $response = Http::get("{$this->baseUrl}/pet/{$id}");
        return $response->successful() ? $response->json() : null;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): ResponseDtoInterface
    {
        $response = Http::post("{$this->baseUrl}/pet", $data);

        return $response->successful() ? new SuccessDto(
            code: $response->status(),
            message: $response->json('message') ?? 'Pet created successfully'
        ) : new FailDto(
            code: $response->status(),
            errorMessage: $response->json('message') ?? 'Failed to create pet'
        );
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(array $data): ResponseDtoInterface
    {
        $response = Http::put("{$this->baseUrl}/pet", $data);

        return $response->successful() ? new SuccessDto(
            code: $response->status(),
            message: $response->json('message') ?? 'Pet updated successfully'
        ) : new FailDto(
            code: $response->status(),
            errorMessage: $response->json('message') ?? 'Failed to update pet'
        );
    }

    public function delete(int $id): ResponseDtoInterface
    {
        $response = Http::delete("{$this->baseUrl}/pet/{$id}");

        return $response->successful() ? new SuccessDto(
            code: $response->status(),
            message: $response->json('message') ?? 'Pet deleted successfully'
        ) : new FailDto(
            code: $response->status(),
            errorMessage: $response->json('message') ?? 'Failed to delete pet'
        );
    }
}
