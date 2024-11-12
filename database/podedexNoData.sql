DROP DATABASE IF EXISTS pokedex;
CREATE DATABASE pokedex CHARACTER SET utf8;
USE pokedex;
CREATE TABLE ability(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(70),
description TEXT,
smallDescription TEXT,
effect TEXT,
effectValue FLOAT,
effectDuration TINYINT,
-- isHidden BOOLEAN,
affect TINYINT UNSIGNED,
moment TINYINT
);
CREATE TABLE type(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(30),
sprite TEXT,
efficiency VARCHAR(75) 
);
CREATE TABLE move(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(70),
description TEXT,
smallDescription TEXT,
accuracy TINYINT UNSIGNED,
type SMALLINT UNSIGNED,
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
);
CREATE TABLE region(
id TINYINT UNSIGNED PRIMARY KEY,
name VARCHAR(75)
);
CREATE TABLE location(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(100),
regionId TINYINT UNSIGNED,
CONSTRAINT location_regionId_FK FOREIGN KEY (regionId) REFERENCES region(id)
);
CREATE TABLE pokemon(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(100),
description TEXT,
species VARCHAR(55),
generation TINYINT UNSIGNED,
category TINYINT UNSIGNED,
spriteM TEXT,
spriteF TEXT,
type1 SMALLINT UNSIGNED,
type2 SMALLINT UNSIGNED,
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
);
CREATE TABLE ability_pokemon(
abilityId SMALLINT UNSIGNED,
pokemonId SMALLINT UNSIGNED,
isHidden BOOLEAN,
CONSTRAINT ability_pokemon_abilityId_FK FOREIGN KEY (abilityId) REFERENCES ability(id),
CONSTRAINT ability_pokemon_pokemonId_FK FOREIGN KEY (pokemonId) REFERENCES pokemon(id),
CONSTRAINT ability_pokemon_PKU UNIQUE (abilityId, pokemonId)
);
CREATE TABLE move_pokemon(
moveId SMALLINT UNSIGNED,
pokemonId SMALLINT UNSIGNED,
learnMethod VARCHAR(100),
learnAtLevel TINYINT UNSIGNED,
generation TINYINT UNSIGNED,
CONSTRAINT move_pokemon_moveId_FK FOREIGN KEY (moveId) REFERENCES move(id),
CONSTRAINT move_pokemon_pokemonId_FK FOREIGN KEY (pokemonId) REFERENCES pokemon(id),
CONSTRAINT move_pokemon_generation_FK FOREIGN KEY (generation) REFERENCES region(id)-- ,
-- CONSTRAINT move_pokemon_PKU UNIQUE (moveId, pokemonId)
);
CREATE TABLE location_pokemon(
locationId SMALLINT UNSIGNED,
pokemonId SMALLINT UNSIGNED,
generation TINYINT UNSIGNED,
CONSTRAINT location_pokemon_locationId_FK FOREIGN KEY (locationId) REFERENCES location(id),
CONSTRAINT location_pokemon_pokemonId_FK FOREIGN KEY (pokemonId) REFERENCES pokemon(id),
CONSTRAINT location_pokemon_generation_FK FOREIGN KEY (generation) REFERENCES region(id)-- ,
-- CONSTRAINT location_pokemon_PKU UNIQUE (locationId, pokemonId, generation)
);
CREATE TABLE item(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(60),
description TEXT,
smallDescription TEXT,
sprite TEXT,
category VARCHAR(30),
pocket VARCHAR(30),
effect TEXT,
throwEffect TEXT,
throwValue SMALLINT,
machineName VARCHAR(50),
machineId SMALLINT UNSIGNED,
CONSTRAINT item_machineId_FK FOREIGN KEY (machineId) REFERENCES move(id)
);
CREATE TABLE evolution_pokemon(
id SMALLINT UNSIGNED,
basePokemonId SMALLINT UNSIGNED,
evoluedPokemonId SMALLINT UNSIGNED,
gender INT,
heldItemId SMALLINT UNSIGNED,
itemId SMALLINT UNSIGNED,
knownMoveId SMALLINT UNSIGNED,
knownMoveTypeId SMALLINT UNSIGNED,
locationId SMALLINT UNSIGNED,
minAffection TINYINT UNSIGNED,
minBeauty TINYINT UNSIGNED,
minHappiness TINYINT UNSIGNED,
minLevel TINYINT UNSIGNED,
needsOverworldRain BOOLEAN,
partySpeciesId VARCHAR(55),
partyTypeId SMALLINT UNSIGNED,
relativePhysicalStats TINYINT,
timeOfDay VARCHAR(50),
tradeSpeciesId SMALLINT UNSIGNED,
evolutionTrigger VARCHAR(70),
turnUpsideDown BOOLEAN,
CONSTRAINT move_evolution_basePokemonId_FK FOREIGN KEY (basePokemonId) REFERENCES pokemon(id),
CONSTRAINT move_evolution_evoluedPokemonId_FK FOREIGN KEY (evoluedPokemonId) REFERENCES pokemon(id),
CONSTRAINT move_evolution_heldItemId_FK FOREIGN KEY (heldItemId) REFERENCES item(id),
CONSTRAINT move_evolution_itemId_FK FOREIGN KEY (itemId) REFERENCES item(id),
CONSTRAINT move_evolution_knownMoveId_FK FOREIGN KEY (knownMoveTypeId) REFERENCES type(id),
CONSTRAINT move_evolution_knownMoveTypeId_FK FOREIGN KEY (knownMoveId) REFERENCES move(id),
CONSTRAINT move_evolution_locationId_FK FOREIGN KEY (locationId) REFERENCES location(id),
CONSTRAINT move_evolution_partyTypeId_FK FOREIGN KEY (partyTypeId) REFERENCES type(id),
CONSTRAINT move_evolution_tradeSpeciesId_FK FOREIGN KEY (tradeSpeciesId) REFERENCES pokemon(id),
CONSTRAINT move_evolution_PKU UNIQUE (id, basePokemonId, evoluedPokemonId)
);
CREATE TABLE form_pokemon(
pokemonId SMALLINT UNSIGNED,
formId SMALLINT UNSIGNED,
CONSTRAINT move_form_pokemonId_FK FOREIGN KEY (pokemonId) REFERENCES pokemon(id),
CONSTRAINT move_form_formId_FK FOREIGN KEY (formId) REFERENCES pokemon(id),
CONSTRAINT form_pokemon_PKU UNIQUE (pokemonId, formId)
);
CREATE TABLE team(
id TINYINT UNSIGNED PRIMARY KEY,
name VARCHAR(25),
spriteBg TEXT,
spriteHead TEXT,
spriteLeft TEXT,
spriteRight TEXT,
spriteBonus TEXT
);
CREATE TABLE combatTeam(
id INT UNSIGNED PRIMARY KEY,
name VARCHAR(25),
pokemon1Id SMALLINT UNSIGNED,
pokemon2Id SMALLINT UNSIGNED,
pokemon3Id SMALLINT UNSIGNED,
pokemon4Id SMALLINT UNSIGNED,
pokemon5Id SMALLINT UNSIGNED,
pokemon6Id SMALLINT UNSIGNED,
CONSTRAINT move_form_pokemon1Id_FK FOREIGN KEY (pokemon1Id) REFERENCES pokemon(id),
CONSTRAINT move_form_pokemon2Id_FK FOREIGN KEY (pokemon2Id) REFERENCES pokemon(id),
CONSTRAINT move_form_pokemon3Id_FK FOREIGN KEY (pokemon3Id) REFERENCES pokemon(id),
CONSTRAINT move_form_pokemon4Id_FK FOREIGN KEY (pokemon4Id) REFERENCES pokemon(id),
CONSTRAINT move_form_pokemon5Id_FK FOREIGN KEY (pokemon5Id) REFERENCES pokemon(id),
CONSTRAINT move_form_pokemon6Id_FK FOREIGN KEY (pokemon6Id) REFERENCES pokemon(id)
);
CREATE TABLE player(
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nickname VARCHAR(50) UNIQUE,
email VARCHAR(100) UNIQUE,
password VARCHAR(100),
level SMALLINT UNSIGNED,
xp SMALLINT UNSIGNED,
team TINYINT UNSIGNED,
picture TEXT,
combatTeam1Id INT UNSIGNED, 
combatTeam2Id INT UNSIGNED,
combatTeam3Id INT UNSIGNED,
selectedCombatTeamId INT UNSIGNED,
friends TEXT,
forumRank TINYINT UNSIGNED,
CONSTRAINT player_team_FK FOREIGN KEY (team) REFERENCES team(id),
CONSTRAINT player_combatTeam1Id_FK FOREIGN KEY (combatTeam1Id) REFERENCES combatTeam(id),
CONSTRAINT player_combatTeam2Id_FK FOREIGN KEY (combatTeam2Id) REFERENCES combatTeam(id),
CONSTRAINT player_combatTeam3Id_FK FOREIGN KEY (combatTeam3Id) REFERENCES combatTeam(id),
CONSTRAINT player_selectedCombatTeamId_FK FOREIGN KEY (selectedCombatTeamId) REFERENCES combatTeam(id)
);
CREATE TABLE player_pokemon(
playerId INT UNSIGNED,
pokemonId SMALLINT UNSIGNED,
CONSTRAINT player_pokemon_playerId_FK FOREIGN KEY (playerId) REFERENCES player(id),
CONSTRAINT player_pokemon_pokemonId_FK FOREIGN KEY (pokemonId) REFERENCES pokemon(id),
CONSTRAINT player_pokemon_PKU UNIQUE (playerId, pokemonId)
);
CREATE TABLE player_favorites(
playerId INT UNSIGNED,
pokemonId SMALLINT UNSIGNED,
CONSTRAINT player_favorites_playerId_FK FOREIGN KEY (playerId) REFERENCES player(id),
CONSTRAINT player_favorites_pokemonId_FK FOREIGN KEY (pokemonId) REFERENCES pokemon(id),
CONSTRAINT player_favorites_PKU UNIQUE (playerId, pokemonId)
);
CREATE TABLE channel(
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
owner INT UNSIGNED,
title VARCHAR(100),
keyWords TINYTEXT,
creationDate DATE,
CONSTRAINT channel_owner_FK FOREIGN KEY (owner) REFERENCES player(id)
);
CREATE TABLE message(
id VARCHAR(160) PRIMARY KEY,
owner INT UNSIGNED,
text TEXT,
reply VARCHAR(160),
imgURL TEXT,
CONSTRAINT message_owner_FK FOREIGN KEY (owner) REFERENCES player(id),
CONSTRAINT message_reply_FK FOREIGN KEY (reply) REFERENCES message(id)
);
CREATE TABLE message_channel(
channelId INT UNSIGNED,
messageId VARCHAR(160),
CONSTRAINT message_channel_channelId_FK FOREIGN KEY (channelId) REFERENCES channel(id),
CONSTRAINT message_channel_messageId_FK FOREIGN KEY (messageId) REFERENCES message(id)
);