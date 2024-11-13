
<?php

// include_once("extractdata.php");
include_once("connectSQL.php");
include_once("sqlQuery.php");

/*
$statement = $db->prepare($sqlCreateAbility);
$statement->execute();

$statement = $db->prepare($sqlCreateType);
$statement->execute();

$statement = $db->prepare($sqlCreateMove);
$statement->execute();

$statement = $db->prepare($sqlCreateRegion);
$statement->execute();

$statement = $db->prepare($sqlCreateLocation);
$statement->execute();

$statement = $db->prepare($sqlCreatePokemon);
$statement->execute();

$statement = $db->prepare($sqlCreateAbilityPokemonLink);
$statement->execute();

$statement = $db->prepare($sqlCreateMovePokemonLink);
$statement->execute();

$statement = $db->prepare($sqlCreateItem);
$statement->execute();

$statement = $db->prepare($sqlCreateEvolutionPokemonLink);
$statement->execute();

$statement = $db->prepare($sqlCreateFormPokemon);
$statement->execute();

$statement = $db->prepare($sqlCreateTeam);
$statement->execute();

$statement = $db->prepare($sqlCreateCombatTeam);
$statement->execute();

$statement = $db->prepare($sqlCreatePlayer);
$statement->execute();

$statement = $db->prepare($sqlCreatePlayerPokedexLink);
$statement->execute();

$statement = $db->prepare($sqlCreatePlayerFavoriteLink);
$statement->execute();
*/

$statement = $db->prepare($sqlCreateAll);
$statement->execute();
$returnResult = $statement->fetchAll();
$statement->closeCursor();
$file = 'pokedexFromPhp.sql';
file_put_contents($file, $sqlCreateAll);

//$state = $statement->fetchAll();
//echo print_r($state);
?>

