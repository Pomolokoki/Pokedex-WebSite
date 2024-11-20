<?php
include_once("extractApi.php");
// "CREATE TABLE evolution_pokemon(
// basePokemonId SMALLINT UNSIGNED,
// evoluedPokemonId SMALLINT UNSIGNED,
// evolutionCondition TEXT,
// itemId SMALLINT UNSIGNED,
// gender INT,
// heldItem INT,
// item INT,
// knownMove INT,
// knownType INT,
// location INt,
// minEffection TINYINT,
// minHapiness TINYINT,
// minLevel TINYINT,
// needsOverworldRain BOOLEAN,
// partySpecies INT,
// partyType INT,
// relativePhysicalStats INT,
// timeOfDay INT,
// tradSpecies INT,
// trigger VARCHAR(50),
// TurnUpsideDown BOOLEAN,
// CONSTRAINT move_evolution_basePokemonId_FK FOREIGN KEY (basePokemonId) REFERENCES pokemon(id),
// CONSTRAINT move_evolution_evoluedPokemonId_FK FOREIGN KEY (evoluedPokemonId) REFERENCES pokemon(id),
// CONSTRAINT move_evolution_itemId_FK FOREIGN KEY (itemId) REFERENCES item(id)

function setEvolution($pokemonEvolutionData, $pokemonData, &$EPvalues, $stade)
{
    for ($j = 0; $j < count($pokemonEvolutionData->evolves_to); $j++)
    {
        $EPvalue = "(";
        $EPvalue = $EPvalue . $pokemonData->id . ","; //id
        $EPvalue = $EPvalue . getidFromUrl($pokemonEvolutionData->species->url) . ","; //baseId
        $EPvalue = $EPvalue . getIdFromUrl($pokemonEvolutionData->evolves_to[$j]->species->url) . ","; //evoluedId
        $evolutionRequires = $pokemonEvolutionData->evolves_to[$j]->evolution_details;

        if (count($evolutionRequires) == 0) { echo "issue"; continue;}
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->gender) . ","; //gender
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ["held_item", "url"])) . ","; //helditemId
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ["item", "url"])) . ","; //itemId
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ["known_move", "url"])) . ","; //knownMoveId
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ["known_move_type" , "url"])) . ","; //knownMoveTypeid
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ["location", "url"])) . ","; //locationId
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->min_affection) . ","; //minAffection
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->min_beauty) . ","; //minBeauty
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->min_happiness) . ","; //minHappiness
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->min_level) . ","; //mionLevel
        $EPvalue = $EPvalue . BooleanValue($evolutionRequires[0]->needs_overworld_rain) . ","; //needsOverworldRain
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ["party_species", "url"])) . ","; //partySpeciesName
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ["party_type", "url"])) . ","; //partytypeId
        $EPvalue = $EPvalue . IntValue($evolutionRequires[0]->relative_physical_stats) . ","; //physicalRelativeStats
        $EPvalue = $EPvalue . getStringReplace($evolutionRequires[0]->time_of_day) . ",";//timeOfDay
        $EPvalue = $EPvalue . getIdFromUrl(exists($evolutionRequires[0], ["trade_species", "url"])) . ","; //tradeSpecies
        $EPvalue = $EPvalue . getTextFromData(exists(getDataFromFile("/evolution-trigger/" . getIdFromUrl(exists($evolutionRequires[0], ["trigger", "url"]))), ["names"]), "name") . ",";
        $EPvalue = $EPvalue . BooleanValue($evolutionRequires[0]->turn_upside_down) . ","; //turnUpsideDown
        $EPvalue = $EPvalue . $stade; // evolutionStade
        $EPvalues = $EPvalues . $EPvalue . "),,";
        
        if ($pokemonEvolutionData->evolves_to[$j]->evolves_to != null && $pokemonData->id != 489 && $pokemonData->id != 490)
        {
            setEvolution($pokemonEvolutionData->evolves_to[$j], $pokemonData, $EPvalues, $stade + 1);
        }
    }
}

$sqlInsertAbilityPokemon = "INSERT INTO ability_pokemon (abilityId, pokemonId, isHidden) VALUES ";
$sqlInsertMovePokemon = "INSERT INTO move_pokemon (moveId, pokemonId, learnMethod, learnAtLevel, generation) VALUES ";
$sqlInsertLocationPokemon = "INSERT INTO location_pokemon (locationId, pokemonId, generation) VALUES ";
$sqlInsertEvolutionPokemon = "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, gender, heldItemId, itemId, knownMoveId, knownMoveTypeId, locationId, minAffection, minBeauty, minHappiness, minLevel, needsOverworldRain, partySpeciesId, partyTypeId, relativePhysicalStats, timeOfDay, tradeSpeciesId, evolutionTrigger, turnUpsideDown, evolutionStade) VALUES ";
$sqlInsertFormPokemon = "INSERT INTO form_pokemon (pokemonId, formId) VALUES ";
$sqlInsertPokemon = "INSERT INTO pokemon (id, name, description, species, category, generation, spriteM, spriteF, type1, type2, hp, attack, defense, atackspe, defensespe, speed ,mega ,height, weight, catch_rate, form, typeEfficiency) VALUES ";
$APvalues = "";
$MPvalues = "";
$LPvalues = "";
$EPvalues = "";
$FPvalues = "";
$values = "";
$typeEfficiencyData = getDataFromFile("pokemon.json", false);

echo count(getDataFromFile("/pokemon")->results);
//echo "<br>";
set_time_limit(1000);
saveToDb($sqlInsertAbilityPokemon, "ability_pokemon", "", true, true);
saveToDb($sqlInsertMovePokemon, "move_pokemon", "", true, true);
saveToDb($sqlInsertEvolutionPokemon, "evolution_pokemon", "", true, true);
saveToDb($sqlInsertFormPokemon, "form_pokemon", "", true, true);
saveToDb($sqlInsertMovePokemon, "pokemon", "", true, true);

foreach (getDataFromFile("/pokemon")->results as $move)
{
    $id = getIdFromUrl($move->url);
    $pokemonData = getDataFromFile("/pokemon/" .$id);
    $pokemonFormData = getDataFromFile("/pokemon-form/" . getIdFromUrl($pokemonData->forms[0]->url));
    $pokemonSpeciesData = getDataFromFile("/pokemon-species/" . getIdFromUrl($pokemonData->species->url));
    $pokemonEvolutionData = getDataFromFile("/evolution-chain/" . getIdFromUrl($pokemonSpeciesData->evolution_chain->url));
    $pokemonEncounterData = getDataFromFile("/pokemon/". $id . "/encounters");
    //echo $pokemonData->id;
    //echo "<br>";


    for ($j = 0; $j < count($pokemonData->abilities); $j++)
    {
        if ($pokemonData->abilities[$j]->slot == 3 && exists($pokemonData->abilities[0], ["ability", "url"]) == $pokemonData->abilities[$j]->ability->url) { continue; }
        $APvalues = $APvalues . "(" . getIdFromUrl($pokemonData->abilities[$j]->ability->url) . ",". $pokemonData->id . "," . BooleanValue($pokemonData->abilities[$j]->is_hidden) . "),,"; //ability_pokemon (table)
    }
    
    
    
    for ($j = 0; $j < count($pokemonData->moves); $j++)
    {
        $groups = $pokemonData->moves[$j]->version_group_details;
        for ($k = 0; $k < count($groups); ++$k)
        {
            
            //$group = $groups[count($groups) - 1];
            
            
            $learnMethodId = getIdFromUrl($groups[$k]->move_learn_method->url);
            if ($learnMethodId == 9 || $learnMethodId == 8 || $learnMethodId == 7)
            {
                continue;
            }
            $versionGroupId = getIdFromUrl($groups[$k]->version_group->url);
            if ($versionGroupId != 1 && $versionGroupId != 3 && $versionGroupId != 5 && $versionGroupId != 8 && $versionGroupId != 11 && $versionGroupId != 15 && $versionGroupId != 17 && $versionGroupId != 20 && $versionGroupId != 25)
            {
                continue;
            }
            $MPvalue = "(";
            $MPvalue = $MPvalue . getIdFromUrl($pokemonData->moves[$j]->move->url) . ",";
            $MPvalue = $MPvalue . $pokemonData->id . ",";
            $MPvalue = $MPvalue . getTextFromData(getDataFromFile("/move-learn-method/" . $learnMethodId)->names, "name") . ",";
            $MPvalue = $MPvalue . IntValue($groups[$k]->level_learned_at) . ",";
            $MPvalue = $MPvalue . getIdFromUrl(getDataFromFile("/version-group/" . $versionGroupId)->generation->url) . ")";
            $MPvalues = $MPvalues . $MPvalue . ",,";
        }
    }

    for ($j = 0; $j < count($pokemonEncounterData); $j++)
    {
        $locationData = getDataFromfile("/location-area/" . getIdFromUrl($pokemonEncounterData[$j]->location_area->url)); 
        for ($k = 0; $k < count($pokemonEncounterData[$j]->version_details); $k++)
        {
            $versionData = getDataFromFile("/version-group/" . getIdFromUrl(getDataFromfile("/version/" . getIdFromUrl($pokemonEncounterData[$j]->version_details[$k]->version->url))->version_group->url));
            $LPvalues = $LPvalues . "(" . getIdFromUrl($locationData->location->url) . ",". $pokemonData->id . "," . getIdFromUrl($versionData->generation->url) . "),,"; //location_pokemon (table)
        }
    }
        
    if ($pokemonEvolutionData != null && $pokemonData->id != 489 && $pokemonData->id != 490)
    {
        setEvolution($pokemonEvolutionData->chain, $pokemonData, $EPvalues, 0);
    }
    if ($pokemonData->id < 10000)
    {
        for ($j = 1; $j < count($pokemonSpeciesData->varieties); $j++)
        {
            $FPvalues = $FPvalues . "(" . getIdFromUrl($pokemonSpeciesData->varieties[0]->pokemon->url) . "," . getIdFromUrl($pokemonSpeciesData->varieties[$j]->pokemon->url) . "),,";
        }
    }
        
    $value = "(" . $pokemonData->id . ','; //id
    if ($pokemonFormData->names != null)
    {
        $value = $value . getTextFromData($pokemonFormData->names, "name") . ","; //name
    }
    else
    {
        $value = $value . getTextFromData($pokemonSpeciesData->names, "name") . ","; //name
    }
    $value = $value . getTextFromData($pokemonSpeciesData->flavor_text_entries, "flavor_text") . ","; //description
    $value = $value . getTextFromData($pokemonSpeciesData->genera, "genus") . ","; //species
    if ($pokemonSpeciesData->is_legendary) //category
    {
        $value = $value . "1,";
    }
    else if ($pokemonSpeciesData->is_mythical)
    {
        $value = $value . "2,";
    }
    else
    {
        $value = $value . "0,";
    }
    $value = $value . getIdFromUrl($pokemonSpeciesData->generation->url) . ","; //generation
    $value = $value . getStringReplace($pokemonData->sprites->front_default) . ','; //priteM
    $value = $value . getStringReplace($pokemonData->sprites->front_female) . ','; //spriteF
    $value = $value . getIdFromUrl($pokemonData->types[0]->type->url) . ","; //type
    if (count($pokemonData->types) == 2)
    {
        $value = $value . getIdFromUrl($pokemonData->types[1]->type->url) . ",";
    }
    else
    {
        $value = $value . 'NULL,';
    }
    $value = $value . IntValue($pokemonData->stats[0]->base_stat) . ","; //hp
    $value = $value . IntValue($pokemonData->stats[1]->base_stat) . ","; //attack
    $value = $value . IntValue($pokemonData->stats[2]->base_stat) . ","; //defense
    $value = $value . IntValue($pokemonData->stats[3]->base_stat) . ","; //attackSpe
    $value = $value . IntValue($pokemonData->stats[4]->base_stat) . ","; //defenseSpe
    $value = $value . IntValue($pokemonData->stats[5]->base_stat) . ","; //speed
    $found = false;
    for ($j = 0; $j < count($pokemonSpeciesData->varieties); $j++)
    {
        if (getDataFromfile("/pokemon-form/" . getIdFromUrl($pokemonSpeciesData->varieties[$j]->pokemon->url))->is_mega == true)
        {
            $value = $value . "TRUE,"; //mega
            $found = true;
            break;
        }
    }
    if ($found != true)
    {
        $value = $value . "FALSE,"; //mega
    }
    $value = $value . $pokemonData->height. ","; //height
    $value = $value . $pokemonData->weight . ","; //weight
    $value = $value . $pokemonSpeciesData->capture_rate . ","; //catch_rate
    $value = $value . count($pokemonData->forms) . ","; //number of forms
    
    if ($pokemonData->id < count($typeEfficiencyData))
    {
        $typeData = ["Normal" => 0, "Combat" => 0, "Vol" => 0, "Poison" => 0, "Sol" => 0, "Roche" => 0, "Insecte" => 0, "Spectre" => 0, "Acier" => 0, "Feu" => 0, "Eau" => 0, "Plante" => 0, "Électrik" => 0, "Psy" => 0, "Glace" => 0, "Dragon" => 0, "Ténèbres" => 0, "Fée" => 0] ;
        $resistances = $typeEfficiencyData[$pokemonData->id]->resistances;
        for ($j = 0; $j < count($resistances); $j++)
        {
            $typeData[$resistances[$j]->name] = $resistances[$j]->multiplier;
        }
        $value = $value . '"' . $typeData["Normal"];
        foreach($typeData as $key)
        {
            $value = $value . "/" . $key;
        }
        $value = $value . '"';
    }
    else
    {
        $value = $value . "NULL";
    }
    $values = $values . $value . "),,";
    
}
saveToDb($sqlInsertPokemon, "pokemon", $values, false);
saveToDb($sqlInsertAbilityPokemon, "ability_pokemon", $APvalues);
saveToDb($sqlInsertMovePokemon, "move_pokemon", $MPvalues);
saveToDb($sqlInsertLocationPokemon, "location_pokemon", $LPvalues);
saveToDb($sqlInsertEvolutionPokemon, "evolution_pokemon", $EPvalues);
saveToDb($sqlInsertFormPokemon, "form_pokemon", $FPvalues);
$sqlAddBonusData = "UPDATE pokemon SET category=3 WHERE id IN (793, 794, 795, 796, 797, 798, 799, 803, 804, 805, 806);\n";
$sqlAddBonusData = $sqlAddBonusData . "UPDATE pokemon SET category=4 WHERE id IN (984, 985, 986, 987, 988, 989, 990, 991, 992, 993, 994, 995, 1005, 1006, 1009, 1010, 1020, 1021, 1022, 1023);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (840, 840, 1011, 2109, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (841, 840, 1011, 2109, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (842, 840, 1011, 2109, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (1011, 840, 1011, 2109, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (1019, 840, 1011, 2109, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, knownMoveId, evolutionTrigger, evolutionStade) VALUES (840, 1011, 1019, 913, \"Level up/Montée de niveau\", 1);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, knownMoveId, evolutionTrigger, evolutionStade) VALUES (841, 1011, 1019, 913, \"Level up/Montée de niveau\", 1);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, knownMoveId, evolutionTrigger, evolutionStade) VALUES (842, 1011, 1019, 913, \"Level up/Montée de niveau\", 1);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, knownMoveId, evolutionTrigger, evolutionStade) VALUES (1011, 1011, 1019, 913, \"Level up/Montée de niveau\", 1);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, knownMoveId, evolutionTrigger, evolutionStade) VALUES (1019, 1011, 1019, 913, \"Level up/Montée de niveau\", 1);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (884, 884, 1018, 60000, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (1018, 884, 1018, 60000, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (1012, 1012, 1013, 2110, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (1013, 1012, 1013, 2110, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (1012, 1012, 1013, 2111, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "INSERT INTO evolution_pokemon (id, basePokemonId, evoluedPokemonId, itemId, evolutionTrigger, evolutionStade) VALUES (1013, 1012, 1013, 2111, \"Use item/Utilisation d'un objet\", 0);\n";
$sqlAddBonusData = $sqlAddBonusData . "UPDATE evolution_pokemon SET basePokemonId = 10161 WHERE basePokemonId = 53;\n";
$sqlAddBonusData = $sqlAddBonusData . "UPDATE evolution_pokemon SET basePokemonId = 10166 WHERE basePokemonId = 83;\n";
$sqlAddBonusData = $sqlAddBonusData . "UPDATE evolution_pokemon SET basePokemonId = 10168 WHERE basePokemonId = 122;\n";
$sqlAddBonusData = $sqlAddBonusData . "UPDATE evolution_pokemon SET basePokemonId = 10173 WHERE basePokemonId = 222;\n";
$sqlAddBonusData = $sqlAddBonusData . "UPDATE evolution_pokemon SET basePokemonId = 10174 WHERE basePokemonId = 264;\n";
$sqlAddBonusData = $sqlAddBonusData . "UPDATE evolution_pokemon SET basePokemonId = 10179 WHERE basePokemonId = 562 AND evoluedPokemonId = 867;\n";
$sqlAddBonusData = $sqlAddBonusData . "UPDATE evolution_pokemon SET basePokemonId = 10253 WHERE basePokemonId = 194 AND evoluedPokemonId = 980;\n";
saveToDb($sqlAddBonusData, "", "", false, true);
//$statement = $db->prepare($sqlAddBonusData);
//$statement->execute();
?>