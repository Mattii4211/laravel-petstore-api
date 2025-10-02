<?php

namespace Tests\Feature\Http\Controllers;

use App\Actions\Pet\Queries\GetPetsQuery;
use App\Http\Controllers\PetController;
use App\Services\PetApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PetControllerIndexFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsPetsFromApi()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/findByStatus*' => Http::response([
                ['id' => 1, 'name' => 'dog'],
                ['id' => 2, 'name' => 'cat'],
            ], 200),
        ]);

        $response = $this->get('/pets');
        $response->assertStatus(200);
        $response->assertViewIs('pets.index');

        $pets = $response->viewData('pets');

        $this->assertCount(2, $pets);
        $this->assertEquals(1, $pets[0]['id']);
        $this->assertEquals('dog', $pets[0]['name']);
        $this->assertEquals(2, $pets[1]['id']);
        $this->assertEquals('cat', $pets[1]['name']);
    }
}
