<?php

namespace Tests\Unit\Services;

use App\Data\Pets\Dto\PetDto;
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

    public function testFindByStatusReturnsDtoArray(): void
    {
        Http::fake([
            '*' => Http::response([
                ['id' => 1, 'name' => 'dog', 'status' => 'available', 'photoUrls' => [], 'tags' => null, 'category' => null],
                ['id' => 2, 'name' => 'cat', 'status' => 'available', 'photoUrls' => [], 'tags' => null, 'category' => null],
            ], 200),
        ]);

        $result = $this->service->findByStatus('available');

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(PetDto::class, $result[0]);
        $this->assertEquals(1, $result[0]->id);
        $this->assertEquals('dog', $result[0]->name);
        $this->assertEquals(2, $result[1]->id);
        $this->assertEquals('cat', $result[1]->name);
    }

    public function testFindByIdReturnsDtoOrNull(): void
    {
        // success case
        Http::fake([
            '*/pet/1' => Http::response(['id' => 1, 'name' => 'dog', 'status' => 'available', 'photoUrls' => [], 'tags' => null, 'category' => null], 200),
        ]);

        $pet = $this->service->findById(1);
        $this->assertInstanceOf(PetDto::class, $pet);
        $this->assertEquals(1, $pet->id);
        $this->assertEquals('dog', $pet->name);

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
