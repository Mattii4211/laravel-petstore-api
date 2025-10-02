<?php

namespace App\Services;

use App\Data\Pets\Dto\FailDto;
use App\Data\Pets\Dto\ResponseDtoInterface;
use App\Data\Pets\Dto\SuccessDto;
use Illuminate\Support\Facades\Http;
use App\Data\Pets\Dto\PetDto;

class PetApiService
{
    protected string $baseUrl;
    
    public function __construct()
    {
        $this->baseUrl = env('PETSTORE_API_URL', 'https://petstore.swagger.io/v2');
    }

    /** @return PetDto[] */
    public function findByStatus(string $status): array
    {
        $response = Http::get("{$this->baseUrl}/pet/findByStatus", ['status' => $status]);

        if (! $response->successful()) {
            return [];
        }

        $pets = $response->json();

        usort($pets, fn ($a, $b) => ($a['id'] ?? 0) <=> ($b['id'] ?? 0));

        return array_map(fn($pet) => PetDto::from([
            'id' => $pet['id'],
            'name' => $pet['name'] ?? '_unknown_',
            'status' => $pet['status'] ?? null,
            'photoUrls' => $pet['photoUrls'] ?? [],
            'tags' => $pet['tags'] ?? null,
            'category' => $pet['category'] ?? null,
        ]), $pets);
    }

    public function findById(int $id): ?PetDto
    {
         $response = Http::get("{$this->baseUrl}/pet/{$id}");

        if (! $response->successful()) {
            return null;
        }

        $data = $response->json();

        $dtoData = [
            'id' => $data['id'],
            'name' => $data['name'] ?? '_unknown_',
            'status' => $data['status'] ?? null,
            'photoUrls' => $data['photoUrls'] ?? [],
            'tags' => $data['tags'] ?? null,
            'category' => $data['category'] ?? null,
        ];

        return PetDto::from($dtoData);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): ResponseDtoInterface
    {
        return $this->handleResponse(Http::post("{$this->baseUrl}/pet", $data), 'Pet created successfully', 'Failed to create pet');
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(array $data): ResponseDtoInterface
    {
        return $this->handleResponse(Http::put("{$this->baseUrl}/pet", $data), 'Pet updated successfully', 'Failed to update pet');
    }

    public function delete(int $id): ResponseDtoInterface
    {
        return $this->handleResponse(Http::delete("{$this->baseUrl}/pet/{$id}"), 'Pet deleted successfully', 'Failed to delete pet');
    }

    protected function handleResponse($response, string $successMessage, string $failMessage): ResponseDtoInterface
    {
        return $response->successful()
            ? new SuccessDto(code: $response->status(), message: $response->json('message') ?? $successMessage)
            : new FailDto(code: $response->status(), errorMessage: $response->json('message') ?? $failMessage);
    }

}
