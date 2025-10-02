<?php

namespace Tests\Feature\Http\Controllers;

use App\Actions\Pet\Enum\Status;
use App\Actions\Pet\Queries\GetPetsQuery;
use App\Http\Controllers\PetController;
use App\Services\PetApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Data\Pets\Dto\PetDto;

class PetControllerIndexFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsPetsFromApi(): void
    {
        $pets = [
            new PetDto(id: 1, name: 'dog', status: Status::AVAILABLE->value, photoUrls: [], tags: null, category: null),
            new PetDto(id: 2, name: 'cat', status: Status::AVAILABLE->value, photoUrls: [], tags: null, category: null),
        ];

        Bus::fake();
        Bus::shouldReceive('dispatch')
            ->once()
            ->withArgs(fn ($query) => $query instanceof GetPetsQuery && $query->status === Status::AVAILABLE->value)
            ->andReturn($pets);

        $response = $this->get('/pets');

        $response->assertStatus(200);
        $response->assertViewIs('pets.index');

        $viewPets = $response->viewData('pets');

        $this->assertCount(2, $viewPets);
        $this->assertInstanceOf(PetDto::class, $viewPets[0]);
        $this->assertEquals(1, $viewPets[0]->id);
        $this->assertEquals('dog', $viewPets[0]->name);
        $this->assertEquals(2, $viewPets[1]->id);
        $this->assertEquals('cat', $viewPets[1]->name);
    }
}
