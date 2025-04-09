<?php
include_once 'extractApi.php';
$sqlInsertEvolution = 'INSERT INTO evolution (id, basePokemonId, evoluedPokemonId, gender, heldItemId, itemId, knownMoveId, knownMoveTypeId, locationId, minAffection, minBeauty, minHappiness, minLevel, needsOverworldRain, partySpeciesId, partyTypeId, relativePhysicalStats, timeOfDay, tradeSpeciesId, evolutionTrigger, turnUpsideDown, evolutionStade) VALUES ';
$values = '';
function setEvolution($pokemonEvolutionData, $id, &$EPvalues, $stade)
{
    for ($j = 0; $j < count($pokemonEvolutionData->evolves_to); $j++)
    {
        $EPvalue = '(';
        $EPvalue = $EPvalue . $id . ','; //id
        $EPvalue = $EPvalue . getidFromUrl($pokemonEvolutionData->species->url) . ','; //baseId
        $EPvalue = $EPvalue . getIdFromUrl($pokemonEvolutionData->evolves_to[$j]->species->url) . ','; //evoluedId
        $evolutionRequires = $pokemonEvolutionData->evolves_to[$j]->evolution_details;

        if (count($evolutionRequires) == 0) { echo 'issue'; continue;}
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->gender) . ','; //gender
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ['held_item', 'url'])) . ','; //helditemId
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ['item', 'url'])) . ','; //itemId
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ['known_move', 'url'])) . ','; //knownMoveId
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ['known_move_type' , 'url'])) . ','; //knownMoveTypeid
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ['location', 'url'])) . ','; //locationId
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->min_affection) . ','; //minAffection
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->min_beauty) . ','; //minBeauty
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->min_happiness) . ','; //minHappiness
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->min_level) . ','; //mionLevel
        $EPvalue = $EPvalue . BooleanValue($evolutionRequires[0]->needs_overworld_rain) . ','; //needsOverworldRain
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ['party_species', 'url'])) . ','; //partySpeciesName
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ['party_type', 'url'])) . ','; //partytypeId
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->relative_physical_stats) . ','; //physicalRelativeStats
        $EPvalue = $EPvalue . getStringReplace($evolutionRequires[0]->time_of_day) . ',';//timeOfDay
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ['trade_species', 'url'])) . ','; //tradeSpecies
        $trigger = exists(getDataFromFile('/evolution-trigger/' . getIdFromUrl(exists($evolutionRequires[0], ['trigger', 'url']))), ['names']);
        $EPvalue = $EPvalue . (getTextFromData($trigger, 'name') == '"NULL///NULL"' ? '"' . getStringReplace(exists(getDataFromFile('/evolution-trigger/' . getIdFromUrl(exists($evolutionRequires[0], ['trigger', 'url']))), ['name']), false) . '///NULL"' : getTextFromData($trigger, 'name')) . ',';
        $EPvalue = $EPvalue . BooleanValue($evolutionRequires[0]->turn_upside_down) . ','; //turnUpsideDown
        $EPvalue = $EPvalue . $stade; // evolutionStade
        $EPvalues = $EPvalues . $EPvalue . '),,';
        
        if ($pokemonEvolutionData->evolves_to[$j]->evolves_to != null)
        {
            setEvolution($pokemonEvolutionData->evolves_to[$j], $id, $EPvalues, $stade + 1);
        }
    }
}

foreach (getDataFromFile('/evolution-chain')->results as $family)
{
    $id = getIdFromUrl($family->url);
    if ($id == 250)
        continue;
    echo $id;
    $evolutionData = getDataFromFile('/evolution-chain/' . $id);
    setEvolution($evolutionData->chain, $id, $values, 0);
}

$sqlAddBonusData = 'INSERT INTO evolution (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (442, 840, 1011, 2109, \'Use item///Utilisation d\\\'un objet\', 0);' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'INSERT INTO evolution (id, basePokemonId, evoluedPokemonId, knownMoveId, evolutionTrigger, evolutionStade) VALUES (442, 1011, 1019, 913, \'Level up///Montée de niveau\', 1);' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'INSERT INTO evolution (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (465, 884, 1018, 60000, \'Use item///Utilisation d\\\'un objet\', 0);' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'INSERT INTO evolution (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (539, 1012, 1013, 2110, \'Use item///Utilisation d\\\'un objet\', 0);' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'INSERT INTO evolution (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (539, 1012, 60000, 2111, \'Use item///Utilisation d\\\'un objet\', 0);' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE evolution SET basePokemonId = 10161 WHERE basePokemonId = 53;' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE evolution SET basePokemonId = 10166 WHERE basePokemonId = 83;' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE evolution SET basePokemonId = 10168 WHERE basePokemonId = 122;' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE evolution SET basePokemonId = 10173 WHERE basePokemonId = 222;' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE evolution SET basePokemonId = 10174 WHERE basePokemonId = 264;' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE evolution SET basePokemonId = 10179 WHERE basePokemonId = 562 AND evoluedPokemonId = 867;' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE evolution SET basePokemonId = 10253 WHERE basePokemonId = 194 AND evoluedPokemonId = 980;' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE evolution SET relativePhysicalStats=0 WHERE id=47 AND basePokemonId=236 AND evoluedPokemonId=237;' . "\n";
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE evolution SET relativePhysicalStats=0 WHERE id=47 AND basePokemonId=236 AND evoluedPokemonId=237;' . "\n";
//$sqlAddBonusData = $sqlAddBonusData . 'ALTER TABLE evolution ADD CONSTRAINT evolution_pokemon_evolutionFamily_FK FOREIGN KEY (evolutionFamilyId) REFERENCES evolution(id)';
saveToDb($sqlInsertEvolution, 'evolution', $values, false);
saveToDb($sqlAddBonusData, '', '', false, true);
