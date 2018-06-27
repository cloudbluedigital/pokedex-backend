<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ixudra\Curl\Facades\Curl;
use App\Pokemon;

class PokemonGet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pokemon:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve pokemon names and save the to db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Purpose of this command is to go and retrieve all names of pokemons for search and save to db which will sync it to algolia
        $client = new \GuzzleHttp\Client();

        $pokemonJson = $client->request('GET', 'https://pokeapi.co/api/v2/pokemon?limit=949');

        $pokemonArray = json_decode((string)$pokemonJson->getBody(), true);
        // Here we will loop throught all of them and strip out not needed data.
        foreach ($pokemonArray['results'] as $key => $value) {
            $pokemonCleanArray[] = [
                'name' => $value['name']
            ];
        }
        // We will insert whole array as bulk insert and trigget searchable to sync to algolia
        Pokemon::insert($pokemonCleanArray);
        Pokemon::all()->searchable();
    }
}
