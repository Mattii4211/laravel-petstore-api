<?php

namespace Tests\Unit\Http\Controllers;

use App\Actions\Pet\Commands\CreatePetCommand;
use App\Actions\Pet\Commands\DeletePetCommand;
use App\Actions\Pet\Commands\UpdatePetCommand;
use App\Actions\Pet\Queries\GetPetByIdQuery;
use App\Actions\Pet\Queries\GetPetsQuery;
use App\Http\Controllers\PetController;
use App\Data\Pets\Dto\CreatePetDto;
use App\Data\Pets\Dto\EditPetDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class PetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexDispatchesGetPetsQueryAndReturnsView()
    {
        Bus::fake();

        $controller = new PetController();
        $response = $controller->index();

        Bus::assertDispatched(GetPetsQuery::class);
        $this->assertStringContainsString('pets.index', $response->name());
        $this->assertArrayHasKey('pets', $response->getData());
    }

    public function testCreateReturnsView()
    {
        $controller = new PetController();
        $response = $controller->create();

        $this->assertStringContainsString('pets.create', $response->name());
    }

    public function testStoreDispatchesCreatePetCommandAndRedirects()
    {
        Bus::fake();
        $dto = new CreatePetDto(
            'dog',
            'available',
            [],
            [],
            null
        );
        $controller = new PetController();
        $response = $controller->store($dto);

        Bus::assertDispatched(CreatePetCommand::class);
        $this->assertStringEndsWith('/pets', $response->getTargetUrl());
    }

    public function testEditReturnsViewIfPetExists()
    {
        Bus::fake();
        Bus::shouldReceive('dispatch')->andReturn(['id' => 1, 'name' => 'dog']);

        $controller = new PetController();
        $response = $controller->edit(1);

        $this->assertStringContainsString('pets.edit', $response->name());
        $this->assertArrayHasKey('pet', $response->getData());
    }

    public function testEditRedirectsIfPetNotFound()
    {
        Bus::fake();
        Bus::shouldReceive('dispatch')->andReturn(null);

        $controller = new PetController();
        $response = $controller->edit(999);

        $this->assertStringEndsWith('/pets', $response->getTargetUrl());
    }

    public function testUpdateDispatchesUpdatePetCommandAndRedirects()
    {
        Bus::fake();
        $dto = new EditPetDto(
            'dog',
            'available',
            null,
            [],
            null
        );

        $controller = new PetController();
        $response = $controller->update($dto, 1);

        Bus::assertDispatched(UpdatePetCommand::class);
        $this->assertStringEndsWith('/pets', $response->getTargetUrl());
    }

    public function testDestroyDispatchesDeletePetCommandAndRedirects()
    {
        Bus::fake();

        $controller = new PetController();
        $response = $controller->destroy(1);

        Bus::assertDispatched(DeletePetCommand::class);
        $this->assertStringEndsWith('/pets', $response->getTargetUrl());
    }
}
