<?php

namespace App\Http\Controllers;

use App\Actions\Pet\Commands\CreatePetCommand;
use App\Actions\Pet\Commands\DeletePetCommand;
use App\Actions\Pet\Commands\UpdatePetCommand;
use App\Actions\Pet\Queries\GetPetByIdQuery;
use App\Actions\Pet\Queries\GetPetsQuery;
use App\Data\Pets\Dto\CreatePetDto;
use App\Data\Pets\Dto\EditPetDto;
use Exception;
use Illuminate\Support\Facades\Bus;

class PetController extends Controller
{
    public function index()
    {
        $pets = Bus::dispatch(new GetPetsQuery('available'));

        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(CreatePetDto $dto)
    {
        try {
            Bus::dispatch(new CreatePetCommand($dto));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['store_error' => $e->getMessage()])->withInput();
        }

        return redirect('/pets');
    }

    public function edit(int $id)
    {
        $pet = Bus::dispatch(new GetPetByIdQuery($id));

        if (! $pet) {
            return redirect('/pets')->withErrors(['Pet not found']);
        }

        return view('pets.edit', compact('pet'));
    }

    public function update(EditPetDto $dto, int $id)
    {
        try {
            Bus::dispatch(new UpdatePetCommand($id, $dto));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['update_error' => $e->getMessage()])->withInput();
        }

        return redirect('/pets');
    }

    public function destroy(int $id)
    {
        try {
            Bus::dispatch(new DeletePetCommand($id));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['delete_error' => $e->getMessage()])->withInput();
        }

        return redirect('/pets');
    }
}
