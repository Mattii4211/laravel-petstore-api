<?php
namespace App\Services;

use App\Data\Pets\Dto\ResponseDtoInterface;
use Illuminate\Support\Facades\Http;
use App\Data\Pets\Dto\FailDto;
use App\Data\Pets\Dto\SuccessDto;

class  PetApiService
{
    protected string $baseUrl = 'https://petstore.swagger.io/v2';

    public function findByStatus(string $status): array
    {
        $response = Http::get("{$this->baseUrl}/pet/findByStatus", ['status' => $status]);
        return $response->successful() ? $response->json() : [];
    }

    public function findById(int $id): ?array
    {
        $response = Http::get("{$this->baseUrl}/pet/{$id}");
        return $response->successful() ? $response->json() : null;
    }

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
