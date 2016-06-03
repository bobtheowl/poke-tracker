<?php

namespace Poketracker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use \Curl;
use Poketracker\Model\Game;
use Poketracker\Model\GamePokemon;
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
        $this->info('Pulling list of all version groups...');
        $versionGroupList = Curl::to('http://pokeapi.co/api/v2/version-group/')->withData(['limit' => 100])->asJson()->get();
        foreach ($versionGroupList->results as $versionGroup) {
            $this->info('Pulling data for version group ' . $versionGroup->name . '...');
            $versionGroupApiData = Curl::to($versionGroup->url)->asJson()->get();
            foreach ($versionGroupApiData->versions as $version) {
                $this->addGame($versionGroupApiData, $version);
            }//end foreach
        }//end foreach

        $this->info('Pulling list of all Pokemon...');
        $pokemonList = Curl::to('http://pokeapi.co/api/v2/pokemon/')->withData(['limit' => 2000])->asJson()->get();
        foreach ($pokemonList->results as $pokemon) {
            if ($this->isNormalPokemon($pokemon->url)) {
                $pokemonData = $this->addPokemon($pokemon);
                $this->linkPokemonToGames($pokemonData);
            }//end if
        }//end foreach
    }//end handle()

    /**
     *
     */
    private function linkPokemonToGames($pokemonData)
    {
        $speciesData = Curl::to($pokemonData->species->url)->asJson()->get();
        foreach ($speciesData->flavor_text_entries as $entry) {
            $pokemon = Pokemon::where('api_name', '=', $pokemonData->name)->first();
            $game = Game::where('api_name', '=', $entry->version->name)->first();
            if (!empty($game) && !empty($pokemon)) {
                $link = GamePokemon::firstOrCreate(['game_id' => $game->id, 'pokemon_id' => $pokemon->id]);
                $link->save();
            }//end if
        }//end foreach
    }//end linkPokemonToGames()

    /**
     *
     */
    private function addGame($group, $game)
    {
        $this->info('Saving ' . $game->name . '...');
        $model = Game::firstOrCreate(['api_name' => strtolower($game->name)]);
        $model->api_name = strtolower($game->name);
        $model->display_name = $this->getGameDisplayName($game->name);
        $model->version_group = strtolower($group->name);
        $model->save();
        $this->info(' -- Data saved!');
    }//end addGame()

    /**
     *
     */
    private function getGameDisplayName($name)
    {
        switch ($name) {
            case 'firered': return 'FireRed';
            case 'leafgreen': return 'LeafGreen';
            case 'heartgold': return 'HeartGold';
            case 'soulsilver': return 'SoulSilver';
            case 'xd': return 'XD';
            case 'black-2': return 'Black 2';
            case 'white-2': return 'White 2';
            case 'omega-ruby': return 'OmegaRuby';
            case 'alpha-sapphire': return 'AlphaSapphire';
            default: return ucwords($name);
        }//end switch
    }//end getGameDisplayName()

    private function addPokemon($pokemon) {
        $this->info('Pulling data for ' . $pokemon->name . '...');
        $pokemonApiData = Curl::to($pokemon->url)->asJson()->get();

        $model = Pokemon::firstOrCreate(['api_name' => strtolower($pokemonApiData->name)]);
        $model->api_name = strtolower($pokemonApiData->name);
        $model->display_name = $this->getPokemonDisplayName($pokemonApiData->name);
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

        return $pokemonApiData;
    }//end addPokemon()

    /**
     *
     */
    private function getPokemonDisplayName($name)
    {
        switch ($name) {
            case 'nidoran-f': return 'Nidoran &female;';
            case 'nidoran-m': return 'Nidoran &male;';
            case 'mr-mime': return 'Mr. Mime';
            case 'ho-oh': return 'Ho-Oh';
            case 'deoxys-normal': return 'Deoxys';
            case 'wormadam-plant': return 'Wormadam';
            case 'mime-jr': return 'Mime Jr.';
            case 'porygon-z': return 'Porygon Z';
            case 'giratina-altered': return 'Giratina';
            case 'shaymin-land': return 'Shaymin';
            case 'basculin-red-striped': return 'Basculin';
            case 'darmanitan-standard': return 'Darmanitan';
            case 'tornadus-incarnate': return 'Tornadus';
            case 'thundurus-incarnate': return 'Thundurus';
            case 'landorus-incarnate': return 'Landorus';
            case 'keldeo-ordinary': return 'Keldeo';
            case 'meloetta-aria': return 'Meloetta';
            case 'meowstic-male': return 'Meowstic';
            case 'aegislash-shield': return 'Aegislash';
            case 'pumpkaboo-average': return 'Pumpkaboo';
            case 'gourgeist-average': return 'Gourgeist';
            default: return ucwords($name);
        }//end switch
    }//end getPokemonDisplayName()

    /**
     *
     */
    private function isNormalPokemon($url)
    {
        $urlArray = explode('/', parse_url($url, PHP_URL_PATH));
        return (intVal($urlArray[4]) < 10000);
    }//end isNormalPokemon()
}//end class RefreshPokemonData
