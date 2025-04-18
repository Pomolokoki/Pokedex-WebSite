<?php
include_once __DIR__ . '/../extractDataFromDB.php';

function GetPokemonsForPokedex()
{
    return executeQueryWReturn('SELECT pokemon.id,
        pokemon.name,
        pokemon.spriteM,
        pokemon.category,
        t1.name AS type1,
        t2.name AS type2
        FROM pokemon 
        JOIN type AS t1 ON pokemon.type1 = t1.id 
        LEFT JOIN type AS t2 ON pokemon.type2 = t2.id 
        WHERE pokemon.id < 100000 ORDER BY pokemon.id',
        null
    );
}

function GetPokemonsForMap()
{
    return executeQueryWReturn('SELECT pokemon.id,
        pokemon.name,
        pokemon.spriteM
        FROM pokemon 
        WHERE pokemon.id < 100000 ORDER BY pokemon.id',
        null
    );
}

function GetTypesForPokedex()
{
    return executeQueryWReturn('SELECT id, name, sprite FROM type', null);
}

function GetTypesForTypeTable()
{
    return executeQueryWReturn('SELECT name, sprite, efficiency FROM type', null);
}

function GetTypesForPokemonMoves()
{
    return executeQueryWReturn('SELECT name FROM type', null);
}


function GetRegions()
{
    return executeQueryWReturn('SELECT id, name FROM region', null);
}

function GetLocations()
{
    return executeQueryWReturn('SELECT id, name FROM location WHERE regionId = 1', null);
}

function GetChannels()
{
    return executeQueryWReturn('SELECT id, title, keyWords, owner FROM channel ORDER BY creationDate LIMIT 25', null);
}

function GetMessages()
{
    return executeQueryWReturn('SELECT message.id,
        message.text,
        message.reply,
        player.id as playerId,
        player.nickname AS nickname,
        player.picture AS profilePicture,
        reply.text AS replyText,
        reply.id AS replyId,
        reply.owner AS replyOwner,
        replyPlayer.nickname AS replyNickname,
        replyPlayer.picture AS replyProfilePicture FROM message
        LEFT JOIN message AS reply ON message.reply = reply.id 
        LEFT JOIN player ON message.owner = player.id 
        LEFT JOIN player AS replyPlayer ON reply.owner = replyPlayer.id 
        WHERE message.channelId = 1 
        ORDER BY message.postDate LIMIT 25', 
null
    );
}

function GetFavoritesChannel($params)
{
    // var_dump($params);
    return executeQueryWReturn('SELECT channelId, title 
        FROM player_fav_channel
        JOIN channel ON channel.id = channelId
        WHERE playerId = :playerId LIMIT 15',
        $params
    );
}

function GetItems()
{
    return executeQueryWReturn('SELECT item.id,
        item.name,
        item.smallDescription,
        item.sprite,
        item.category,
        item.pocket,
        item.effect
        FROM item',
        null
    );
}

function getPokemonMoves()
{
    return executeQueryWReturn('SELECT move.name,
        smallDescription,
        accuracy,
        pp,
        pc,
        type.name AS type,
        priority,
        criticity,
        effectType
        FROM move
        JOIN type ON type.id = move.type 
        ORDER BY name',
null
    );
}

function getPokemonMove($params)
{
    return executeQueryWReturn('SELECT move.name,
        smallDescription,
        accuracy,
        pp,
        pc,
        type.name AS type,
        priority,
        criticity,
        effectType
        FROM move
        JOIN type ON type.id = move.type 
        WHERE move.id = :id 
        ORDER BY name',
$params
    );
}

function getFavoritePokemon($params)
{
    return executeQueryWReturn('SELECT pokemon.name as pokemonName,
        pokemon.spriteM as pokemonSprite,
        pokemon.id as pokemonId 
        FROM pokemon
        INNER JOIN player_favorites ON pokemon.id = pokemonId AND playerId = :userId',
$params
    );
}

function getPokemonCaught($params)
{
    return executeQueryWReturn('SELECT pokemon.name as pokemonName,
        pokemon.spriteM as pokemonSprite,
        pokemon.id as pokemonId 
        FROM pokemon
        INNER JOIN player_pokemon ON pokemon.id = pokemonId AND playerId = :userId',
$params
    );
}