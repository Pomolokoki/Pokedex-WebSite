<?php

include_once '../extractDataFromDB.php';

if (!isset($_GET['request'])) {
    header("Location: unauthorized.php");
    return;
}

function GetLocationFromRegion($params)
{
    return json_encode(executeQueryWReturn('SELECT location.name FROM location
        JOIN region ON location.regionId = region.id
        WHERE region.name LIKE :regionName',
        $params
    ));
}

function GetLocationFromPokemon($params)
{
    return json_encode(executeQueryWReturn('SELECT DISTINCT location.name FROM location 
        INNER JOIN location_pokemon AS lp ON location.id = lp.locationId 
        INNER JOIN region ON location.regionId = region.id 
        WHERE region.name LIKE :regionName AND lp.pokemonId=:pokemonId',
        $params
    ));
}

function GetPokemonFromRegion($params)
{
    return json_encode(executeQueryWReturn('SELECT DISTINCT pokemon.id FROM pokemon 
        JOIN location_pokemon AS lp ON pokemon.id = lp.pokemonId 
        JOIN region ON lp.generation = region.id 
        WHERE region.name LIKE :regionName',
        $params
    ));
}

function GetPokemonFromLocation($params)
{
    return json_encode(executeQueryWReturn('SELECT DISTINCT pokemon.id FROM pokemon 
        JOIN location_pokemon AS lp ON pokemon.id = lp.pokemonId 
        JOIN location ON location.id = lp.locationId 
        JOIN region ON lp.generation = region.id 
        WHERE region.name LIKE :regionName AND location.name LIKE :location',
        $params
    ));
}

function GetInfoPokemonFromRegion($params)
{
    return json_encode(executeQueryWReturn('SELECT DISTINCT pokemon.id,
        pokemon.name,
        pokemon.spriteM
        FROM pokemon 
        JOIN location_pokemon AS lp ON pokemon.id = lp.pokemonId 
        JOIN region ON lp.generation = region.id 
        WHERE region.name LIKE :regionName',
        $params
    ));
}

$req = $_GET['request'];

switch ($req) {
    case 'GetLocationFromRegion':
        echo GetLocationFromRegion([':regionName' => $_GET[1] . '%']);
        break;

    case 'GetLocationFromPokemon':
        echo GetLocationFromPokemon([
            ':regionName' => $_GET[1] . '%',
            ':pokemonId' => $_GET[2]
        ]);
        break;

    case 'GetPokemonFromRegion':
        echo GetPokemonFromRegion([
            ':regionName' => $_GET[1] . '%']
        );
        break;

    case 'GetPokemonFromLocation':
        echo GetPokemonFromLocation([
            ':regionName' => $_GET[1] . '%',
            ':location' => $_GET[2] . '%'
        ]);
        break;
    
    case 'GetInfoPokemonFromRegion':
        echo GetInfoPokemonFromRegion([
            ':regionName' => $_GET[1] . '%']
        );
        break;
}
