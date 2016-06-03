<?php

namespace Poketracker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use \Curl;
use \Poketracker\Model\Pokemon;

class RefreshPokemonData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pokemon:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls new Pokemon data from the API.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Pulling list of all Pokemon...');
        $pokemonList = Curl::to('http://pokeapi.co/api/v2/pokemon/')->withData(['limit' => 2000])->asJson()->get();
        foreach ($pokemonList->results as $pokemon) {
            if ($this->isNormalPokemon($pokemon->url)) {
                $this->info('Pulling data for ' . $pokemon->name . '...');
                $pokemonApiData = Curl::to($pokemon->url)->asJson()->get();

                $model = Pokemon::firstOrCreate(['api_name' => strtolower($pokemonApiData->name)]);
                $model->api_name = strtolower($pokemonApiData->name);
                $model->display_name = ucwords($pokemonApiData->name);
                if (property_exists($pokemonApiData, 'sprites') && !empty($pokemonApiData->sprites)) {
                    $model->sprite_normal_url = (
                        property_exists($pokemonApiData->sprites, 'front_default') &&
                        !empty($pokemonApiData->sprites->front_default)
                    ) ? $pokemonApiData->sprites->front_default : '';
                    $model->sprite_shiny_url = (
                        property_exists($pokemonApiData->sprites, 'front_shiny') &&
                        !empty($pokemonApiData->sprites->front_shiny)
                    ) ? $pokemonApiData->sprites->front_shiny : '';
                }
                else {
                    $model->sprite_normal_url = '';
                    $model->sprite_shiny_url = '';
                }//end if/else

                $model->save();
                $this->info(' -- Data saved!');
            }//end if
        }//end foreach
    }//end handle()

    /**
     *
     */
    private function isNormalPokemon($url)
    {
        $urlArray = explode('/', parse_url($url, PHP_URL_PATH));
        return (intVal($urlArray[4]) < 10000);
    }//end isNormalPokemon()
}//end class RefreshPokemonData
