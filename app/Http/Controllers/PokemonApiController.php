<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\PokemonFacade as PokemonRepository;

class PokemonApiController extends Controller
{
    public function data(Request $request)
    {
        $pokemon = PokemonRepository::pokemonData($request->query('pokemon'));
        return $pokemon;
    }
    public function retrieveAllPokemon(Request $request)
    {
        $pokemon = PokemonRepository::allPokemon($request->query('page'));
        return $pokemon;
    }
}
