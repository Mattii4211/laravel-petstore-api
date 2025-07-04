<?php

namespace App\Providers;

use App\Actions\Pet\Commands\CreatePetCommand;
use App\Actions\Pet\Commands\DeletePetCommand;
use App\Actions\Pet\Commands\UpdatePetCommand;
use App\Actions\Pet\Handlers\CreatePetHandler;
use App\Actions\Pet\Handlers\DeletePetHandler;
use App\Actions\Pet\Handlers\GetPetByIdHandler;
use App\Actions\Pet\Handlers\GetPetsHandler;
use App\Actions\Pet\Handlers\UpdatePetHandler;
use App\Actions\Pet\Queries\GetPetByIdQuery;
use App\Actions\Pet\Queries\GetPetsQuery;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Bus::map([
            GetPetsQuery::class => GetPetsHandler::class,
            GetPetByIdQuery::class => GetPetByIdHandler::class,
            CreatePetCommand::class => CreatePetHandler::class,
            UpdatePetCommand::class => UpdatePetHandler::class,
            DeletePetCommand::class => DeletePetHandler::class,
        ]);
    }
}
