<?php

namespace Tests\Unit\Services;

use App\Services\PetApiService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PetApiServiceTest extends TestCase
{
    private PetApiService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PetApiService();
    }

    public function testFindByStatusReturnsArray(): void
    {
        Http::fake([
            '*' => Http::response([
                ['id' => 1, 'name' => 'dog', 'status' => 'available'],
                ['id' => 2, 'name' => 'cat', 'status' => 'available'],
            ], 200),
        ]);

        $result = $this->service->findByStatus('available');
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);
    }

    public function testFindByIdReturnsArrayOrNull(): void
    {
        // success case
        Http::fake([
            '*/pet/1' => Http::response(['id' => 1, 'name' => 'dog'], 200),
        ]);

        $pet = $this->service->findById(1);
        $this->assertIsArray($pet);
        $this->assertEquals(1, $pet['id']);

        // failure case
        Http::fake([
            '*/pet/999' => Http::response([], 404),
        ]);

        $pet = $this->service->findById(999);
        $this->assertNull($pet);
    }

    public function testCreateReturnsSuccessDto(): void
    {
        Http::fake([
            '*' => Http::response(['message' => 'Created'], 200),
        ]);

        $dto = $this->service->create([
            'id' => 1,
            'name' => 'dog',
            'status' => 'available',
            'photoUrls' => [],
            'tags' => [],
        ]);

        $this->assertEquals('Created', $dto->getMessage());
    }

    public function testUpdateReturnsFailDtoOnError(): void
    {
        Http::fake([
            '*' => Http::response(['message' => 'Error'], 500),
        ]);

        $dto = $this->service->update([
            'id' => 1,
            'name' => 'dog',
            'status' => 'available',
        ]);

        $this->assertEquals('Error', $dto->getMessage());
    }
}
