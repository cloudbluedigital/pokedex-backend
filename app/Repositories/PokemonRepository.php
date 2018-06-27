<?php

namespace App\Repositories;

use App\Http\Resources\PokemonResource;
use App\Pokemon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class PokemonRepository
{
    public function allPokemon($page)
    {
        try {
            $pokemon = Cache::tags('pokemon')->rememberForever('pokemon-' . $page, function () {
                return new PokemonResource(Pokemon::paginate('15'));
            });
        } catch (Exception $error) {
            Log::error('Retrieving pokemons failed:', ['error' => $error->getMessage()]);
        }
        return $pokemon;
    }
    public function pokemonData($pokemon)
    {   
        // This could be done better but time restrictions apply

        if (Cache::has($pokemon)) {
            return Cache::get($pokemon);
        }


        $client = new \GuzzleHttp\Client();

        $pokemonJson = $client->request('GET', 'https://pokeapi.co/api/v2/pokemon/' . $pokemon);

        $pokemonArray = json_decode((string)$pokemonJson->getBody(), true);

        $abilities = $pokemonArray['abilities'];
        $height = $pokemonArray['height'];
        $weight = $pokemonArray['height'];
        $name = $pokemonArray['name'];
        $species = $pokemonArray['species']['name'];
        // ?? cannot find image of pokemon? probobly did miss it.

        $sortedArray[] = [
            'abilities' => $abilities,
            'height' => $height,
            'weight' => $weight,
            'name' => $name,
            'species' => $species
        ];
        Cache::put($pokemon, $sortedArray, '60'); // of course it's just an example it can stored for however long we want or store forever and refresh on conditions

        return $sortedArray;
    }
}