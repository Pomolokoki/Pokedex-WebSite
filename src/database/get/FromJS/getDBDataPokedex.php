<?php
if (!isset($_GET['request'])) {
    header("Location: unauthorized.php");
    return;
}

include_once '../extractDataFromDB.php';

function GetPokemon($params)
{
    return  json_encode(
        executeQueryWReturn(
            'SELECT pokemon.id,
        pokemon.name,
        pokemon.spriteM,
        pokemon.category,
        pokemon.generation,
        t1.name AS type1,
        t2.name AS type2
        FROM pokemon 
        JOIN type AS t1 ON pokemon.type1 = t1.id 
        LEFT JOIN type AS t2 ON pokemon.type2 = t2.id 
        WHERE pokemon.id < 100000 ORDER BY pokemon.id LIMIT 25,70000',
            $params
        )
    );
}

function GetPokemonData($params)
{
    return json_encode(
        executeQueryWReturn(
            'SELECT pokemon.id,
        pokemon.name,
        pokemon.spriteM,
        pokemon.spriteF,
        pokemon.generation,
        pokemon.category,
        pokemon.height,
        pokemon.weight,
        pokemon.catch_rate,
        pokemon.hp,
        pokemon.attack,
        pokemon.defense,
        pokemon.atackspe,
        pokemon.defensespe,
        pokemon.speed,
        pokemon.typeEfficiency, 
        pokemon.description, 
        t1.name AS type1, 
        t2.name AS type2 
        FROM pokemon JOIN type AS t1 ON pokemon.type1 = t1.id LEFT JOIN type AS t2 ON pokemon.type2 = t2.id WHERE pokemon.id=:pokemonId',
            $params
        )
    );
}

function GetAbilityData($params)
{
    return json_encode(
        executeQueryWReturn(
            'SELECT ability.name,  ability.smallDescription, ap.isHidden FROM ability_pokemon AS ap 
        INNER JOIN ability ON ap.abilityId = ability.id 
        WHERE ap.pokemonId=:pokemonId',
            $params
        )
    );
    
}

function GetMoveData($params)
{
    return json_encode(
        executeQueryWReturn(
            'SELECT move.name, type.name AS type, move.effectType, move.pc,  move.accuracy, mp.learnMethod, mp.learnAtLevel, move.pp 
        FROM move_pokemon AS mp INNER JOIN move ON mp.moveId = move.id JOIN type ON move.type = type.id WHERE mp.pokemonId=:pokemonId AND mp.generation=:gen',
            $params
        )
    );
}

function GetEvolutionData($params)
{
    return json_encode(
        executeQueryWReturn(
            'SELECT DISTINCT
            ev.id,
            ev.basePokemonId,
            ev.evoluedPokemonId,
            ev.evolutionStade,
            ev.gender,
            it1.name AS it1name,
            it1.sprite AS it1sprite,
            it2.name AS it2name,
            it2.sprite AS it2sprite,
            move.name AS moveName,
            ty1.name AS tyName,
            location.name AS locationName,
            ev.minAffection,
            ev.minBeauty,
            ev.minHappiness,
            ev.minLevel,
            ev.needsOverworldRain,
            po3.name AS n3,
            ty2.name AS ty2Name,
            ev.relativePhysicalStats,
            ev.timeOfDay,
            ev.tradeSpeciesId,
            ev.evolutionTrigger,
            po4.name AS n4,
            ev.turnUpSideDown,

            po1.spriteM AS s1,
            po1.name AS n1,
            po1.type1 AS type11,
            po1.type2 AS type12,
            po1.id AS id1, 

            po2.spriteM AS s2,
            po2.name AS n2,
            po2.type1 AS type21,
            po2.type2 AS type22,
            po2.id AS id2   

            FROM evolution AS ev 
            LEFT JOIN pokemon AS po1 ON basePokemonId = po1.id 
            LEFT JOIN pokemon AS po2 ON evoluedPokemonId = po2.id 
            LEFT JOIN item AS it1 ON heldItemId = it1.id 
            LEFT JOIN item AS it2 ON itemId = it2.id 
            LEFT JOIN move ON knownMoveId = move.id 
            LEFT JOIN type AS ty1 ON knownMoveTypeId = ty1.id 
            LEFT JOIN location ON locationId = location.id 
            LEFT JOIN pokemon AS po3 ON partySpeciesId = po3.id 
            LEFT JOIN type AS ty2 ON partyTypeId = ty2.id 
            LEFT JOIN pokemon AS po4 ON tradeSpeciesId = po4.id 

            LEFT JOIN type AS t11 ON po1.type1 = t11.id 
            LEFT JOIN type AS t12 ON po1.type2 = t12.id 
            LEFT JOIN type AS t21 ON po2.type1 = t21.id  
            LEFT JOIN type AS t22 ON po2.type2 = t22.id 

            LEFT JOIN evolution_pokemon ON ev.id = evolutionFamilyId 

            WHERE evolutionFamilyId = (SELECT evolutionFamilyId FROM evolution_pokemon WHERE pokemonId=:pokemonId)',
            $params
        )
    );
}

function AddFav($params)
{
    return executeQuery(
        'INSERT INTO player_favorites VALUES (:playerId, :pokemonId)',
        $params
    );
}

function RemoveFav($params)
{
    return executeQuery(
        'DELETE FROM player_favorites WHERE playerId=:playerId AND pokemonId=:pokemonId',
        $params
    );
}

function AddPlayerPokemon($params)
{
    return executeQuery(
        'INSERT INTO player_pokemon VALUES (:playerId, :pokemonId)',
        $params
    );
}

function RemovePlayerPokemon($params)
{
    return executeQuery(
        'DELETE FROM player_pokemon WHERE playerId=:playerId AND pokemonId=:pokemonId',
        $params
    );
}

function GetFav($params)
{
    return json_encode(executeQueryWReturn(
        'SELECT pf.pokemonId AS pokemonFav FROM player_favorites AS pf WHERE pf.playerId=:playerId AND pf.pokemonId=:pokemonId',
        $params
    ));
}

function GetPlayerPokemon($params)
{
    return json_encode(executeQueryWReturn(
        'SELECT pp.pokemonId AS pokemonPlayer FROM player_pokemon AS pp WHERE pp.playerId=:playerId AND pp.pokemonId=:pokemonId',
        $params
    ));
}




$req = $_GET['request'];
switch ($req) {
    case 'GetPokemon':
        echo GetPokemon([]);
        return;

    case 'GetPokemonData':
        echo GetPokemonData([':pokemonId' => $_GET[1]]);
        return;

    case 'GetAbilityData':
        echo GetAbilityData([':pokemonId' => $_GET[1]]);
        return;

    case 'GetMoveData':
        echo GetMoveData([
            ':pokemonId' => $_GET[1],
            ':gen' => $_GET[2]
        ]);
        return;

    case 'GetEvolutionData':
        echo GetEvolutionData([':pokemonId' => $_GET[1]]);
        return;
}



if (!isset($_SESSION) || !isset($_SESSION['LOGGED_USER']) || !isset($_SESSION['LOGGED_USER'][0])) {
    header("Location: unauthorized.php");
    return;
}

switch ($req) {
    case 'AddFav':
        echo AddFav([
            ':playerId' => $_GET[1],
            ':pokemonId' => $_GET[2]
        ]);
        break;

    case 'RemoveFav':
        echo RemoveFav([
            ':playerId' => $_GET[1],
            ':pokemonId' => $_GET[2]
        ]);
        break;

    case 'AddPlayerPokemon':
        echo AddPlayerPokemon([
            ':playerId' => $_GET[1],
            ':pokemonId' => $_GET[2]
        ]);
        break;

    case 'RemovePlayerPokemon':
        echo RemovePlayerPokemon([
            ':playerId' => $_GET[1],
            ':pokemonId' => $_GET[2]
        ]);
        break;

    case 'GetFav':
        echo GetFav([
            ':playerId' => $_GET[1],
            ':pokemonId' => $_GET[2]
        ]);
        break;

    case 'GetPlayerPokemon':
        echo GetPlayerPokemon([
            ':playerId' => $_GET[1],
            ':pokemonId' => $_GET[2]
        ]);
        break;
}
