
<?php

include_once("extractdata.php");

$sqlCreateBD = 
"DROP DATABASE IF EXISTS pokedex;
CREATE DATABASE pokedex CHARACTER SET utf8;
USE pokedex;";

$sqlCreateAbility =
"CREATE TABLE ability(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(70),
description TEXT,
smallDescription TEXT,
effect VARCHAR(25),
effectValue FLOAT,
effectDuration TINYINT,
-- isHidden BOOLEAN,
affect TINYINT UNSIGNED,
moment TINYINT
);";

$sqlCreateType =
"CREATE TABLE type(
id TINYINT UNSIGNED PRIMARY KEY,
name VARCHAR(30),
sprite TEXT,
efficiency VARCHAR(75) 
);";


$sqlCreateMove =
"CREATE TABLE move(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(70),
description TEXT,
smallDescription TEXT,
accuracy TINYINT UNSIGNED,
type TINYINT UNSIGNED,
pc TINYINT UNSIGNED,
pp TINYINT UNSIGNED,
statut VARCHAR(25),
effect VARCHAR(25),
effectValue FLOAT,
effectDuration TINYINT,
effectType TINYINT UNSIGNED,
affect INT UNSIGNED,
comboMin TINYINT UNSIGNED,
comboMax TINYINT UNSIGNED,
priority BOOLEAN,
criticity FLOAT,
-- influenced TINYINT,
-- learnship TINYINT,
CONSTRAINT move_type_FK FOREIGN KEY (type) REFERENCES type(id)
);";

$sqlCreatePokemon =
"CREATE TABLE pokemon(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(100),
description TEXT,
species VARCHAR(55),
generation TINYINT UNSIGNED,
category TINYINT UNSIGNED,
spriteM TEXT,
spriteF TEXT,
type1 TINYINT UNSIGNED,
type2 TINYINT UNSIGNED,
-- ability1 SMALLINT UNSIGNED,
-- ability2 SMALLINT UNSIGNED,
-- ability3 SMALLINT UNSIGNED,
hp SMALLINT UNSIGNED,
attack TINYINT UNSIGNED,
defense TINYINT UNSIGNED,
atackspe TINYINT UNSIGNED,
defensespe TINYINT UNSIGNED,
speed TINYINT UNSIGNED,
typeEfficiency VARCHAR(255),
-- evolSup VARCHAR(100),
-- conditionEvol VARCHAR(100),
-- evolInf FLOAT UNSIGNED,
mega BOOLEAN,
height VARCHAR(10),
weight VARCHAR(10),
catch_rate SMALLINT,
-- moves TEXT,
form SMALLINT,
CONSTRAINT pokemeon_type1_FK FOREIGN KEY (type1) REFERENCES type(id),
CONSTRAINT pokemeon_type2_FK FOREIGN KEY (type2) REFERENCES type(id)-- ,
-- CONSTRAINT pokemeon_ability1_FK FOREIGN KEY (ability1) REFERENCES ability(id),
-- CONSTRAINT pokemeon_ability2_FK FOREIGN KEY (ability2) REFERENCES ability(id),
-- CONSTRAINT pokemeon_ability3_FK FOREIGN KEY (ability3) REFERENCES ability(id)
);";

$sqlCreateAbilityPokemonLink =
"CREATE TABLE ability_pokemon(
abilityId SMALLINT UNSIGNED,
pokemonId SMALLINT UNSIGNED,
isHidden BOOLEAN,
CONSTRAINT ability_pokemon_abilityId_FK FOREIGN KEY (abilityId) REFERENCES ability(id),
CONSTRAINT ability_pokemon_pokemonId_FK FOREIGN KEY (pokemonId) REFERENCES pokemon(id)
);";

$sqlCreateMovePokemonLink = 
"CREATE TABLE move_pokemon(
moveId SMALLINT UNSIGNED,
pokemonId SMALLINT UNSIGNED,
learnMethod TINYINT UNSIGNED,
learnAtLevel TINYINT UNSIGNED,
CONSTRAINT move_pokemon_moveId_FK FOREIGN KEY (moveId) REFERENCES move(id),
CONSTRAINT move_pokemon_pokemonId_FK FOREIGN KEY (pokemonId) REFERENCES pokemon(id)
);";

$sqlCreateItem =
"CREATE TABLE item(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(50),
description TEXT,
sprite TEXT,
statut VARCHAR(25),
effect VARCHAR(25),
effectValue FLOAT,
oneUse BOOLEAN
);";

$sqlCreateEvolutionPokemonLink = 
"CREATE TABLE evolution_pokemon(
basePokemonId SMALLINT UNSIGNED,
evoluedPokemonId SMALLINT UNSIGNED,
evolutionCondition TEXT,
itemId SMALLINT UNSIGNED,
CONSTRAINT move_evolution_basePokemonId_FK FOREIGN KEY (basePokemonId) REFERENCES pokemon(id),
CONSTRAINT move_evolution_evoluedPokemonId_FK FOREIGN KEY (evoluedPokemonId) REFERENCES pokemon(id),
CONSTRAINT move_evolution_itemId_FK FOREIGN KEY (itemId) REFERENCES item(id)
);";

$sqlCreatePokeball =
"CREATE TABLE pokeball(
id TINYINT UNSIGNED PRIMARY KEY,
name VARCHAR(25),
description TEXT,
sprite TEXT,
captureRate FLOAT
);";

$sqlCreateTeam =
"CREATE TABLE team(
id TINYINT UNSIGNED PRIMARY KEY,
name VARCHAR(25),
spriteBg TEXT,
spriteHead TEXT,
spriteLeft TEXT,
spriteRight TEXT,
spriteBonus TEXT
);";

$sqlCreateCombatTeam =
"CREATE TABLE combatTeam
(
id INT UNSIGNED PRIMARY KEY,
name VARCHAR(25),
pokemon1 FLOAT,
pokemon2 FLOAT,
pokemon3 FLOAT,
pokemon4 FLOAT,
pokemon5 FLOAT,
pokemon6 FLOAT
);";

$sqlCreatePlayer =
"CREATE TABLE player(
id INT UNSIGNED PRIMARY KEY,
nickname VARCHAR(50),
level SMALLINT UNSIGNED,
xp SMALLINT UNSIGNED,
team TINYINT UNSIGNED,
picture TEXT,
combatTeam1 INT UNSIGNED, 
combatTeam2 INT UNSIGNED,
combatTeam3 INT UNSIGNED,
selectedTeam INT UNSIGNED,
favorites TEXT,
pokedex TEXT,
friends TEXT,
CONSTRAINT player_team_FK FOREIGN KEY (team) REFERENCES team(id),
CONSTRAINT player_combatTeam1_FK FOREIGN KEY (combatTeam1) REFERENCES combatTeam(id),
CONSTRAINT player_combatTeam2_FK FOREIGN KEY (combatTeam2) REFERENCES combatTeam(id),
CONSTRAINT player_combatTeam_FK FOREIGN KEY (combatTeam3) REFERENCES combatTeam(id)
);";


$statement = $db->prepare($sqlCreateBD);
$statement->execute();

$statement = $db->prepare($sqlCreateAbility);
$statement->execute();

$statement = $db->prepare($sqlCreateType);
$statement->execute();

$statement = $db->prepare($sqlCreateMove);
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

$statement = $db->prepare($sqlCreatePokeball);
$statement->execute();

$statement = $db->prepare($sqlCreateTeam);
$statement->execute();

$statement = $db->prepare($sqlCreateCombatTeam);
$statement->execute();

$statement = $db->prepare($sqlCreatePlayer);
$statement->execute();

//$state = $statement->fetchAll();
//echo print_r($state);
?>

