<?php
include_once '../database/extractDataFromDB.php';
//var_dump($_GET);
$req = $_GET['request'];
switch ($req) {
    case 'GetLocationFromRegion':
        echo json_encode(executeQueryWReturn('SELECT location.name FROM location
            JOIN region ON location.regionId = region.id
            WHERE region.name LIKE :regionName', [':regionName' => $_GET[1] . '%']
        ));
        break;

    case 'GetLocationFromPokemon':
        $id = $_GET[1];
        //if (!is_numeric($id))
        //    return 'No results found.';
        //echo $id;
        echo json_encode(executeQueryWReturn('SELECT DISTINCT location.name FROM location 
            INNER JOIN location_pokemon AS lp ON location.id = lp.locationId 
            INNER JOIN region ON location.regionId = region.id 
            WHERE region.name LIKE :regionName AND lp.pokemonId=:pokemonId', [
            ':regionName' => $_GET[1] . '%',
            ':pokemonId' => $_GET[2]
        ]));
        break;

    case 'GetPokemonFromRegion':
        echo json_encode(executeQueryWReturn('SELECT DISTINCT pokemon.id FROM pokemon 
            JOIN location_pokemon AS lp ON pokemon.id = lp.pokemonId 
            JOIN region ON lp.generation = region.id 
            WHERE region.name LIKE :regionName', [':regionName' => $_GET[1] . '%']
            ));
        break;

    case 'GetPokemonFromLocation':
        $id = $_GET[1];
        //if (!is_numeric($id))
        //    return 'No results found.';
        //echo $id;
        echo json_encode(executeQueryWReturn('SELECT DISTINCT pokemon.id FROM pokemon 
            JOIN location_pokemon AS lp ON pokemon.id = lp.pokemonId 
            JOIN location ON location.id = lp.locationId 
            JOIN region ON lp.generation = region.id 
            WHERE region.name LIKE :regionName AND location.name LIKE :location', [
            ':regionName' => $_GET[1] . '%',
            ':location' => $_GET[2] . '%'
        ]));
        break;

    default:
        echo json_encode(getDataFromDB($_GET['request'], null, null, true));
        break;
}
