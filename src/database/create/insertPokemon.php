<?php
include_once 'extractApi.php';

$sqlInsertAbilityPokemon = 'INSERT INTO ability_pokemon (abilityId, pokemonId, isHidden) VALUES ';
$sqlInsertMovePokemon = 'INSERT INTO move_pokemon (moveId, pokemonId, learnMethod, learnAtLevel, generation) VALUES ';
$sqlInsertLocationPokemon = 'INSERT INTO location_pokemon (locationId, pokemonId, generation) VALUES ';
$sqlInsertEvolutionPokemon = 'INSERT INTO evolution_pokemon (pokemonId, evolutionFamilyId) VALUES ';
$sqlInsertFormPokemon = 'INSERT INTO form_pokemon (pokemonId, formId) VALUES ';
$sqlInsertPokemon = 'INSERT INTO pokemon (id, name, description, species, category, generation, spriteM, spriteF, type1, type2, hp, attack, defense, atackspe, defensespe, speed ,mega ,height, weight, catch_rate, form, typeEfficiency) VALUES ';
$APvalues = '';
$MPvalues = '';
$LPvalues = '';
$EPvalues = '';
$FPvalues = '';
$values = '';
$typeEfficiencyData = getDataFromFile('pokemon.json', false);

echo count(getDataFromFile('/pokemon')->results);
//echo '<br>';
set_time_limit(1000);
saveToDb($sqlInsertAbilityPokemon, 'ability_pokemon', '', true, true);
saveToDb($sqlInsertMovePokemon, 'move_pokemon', '', true, true);
saveToDb($sqlInsertEvolutionPokemon, 'evolution_pokemon', '', true, true);
saveToDb($sqlInsertFormPokemon, 'form_pokemon', '', true, true);
saveToDb($sqlInsertMovePokemon, 'pokemon', '', true, true);

foreach (getDataFromFile('/pokemon')->results as $pokemon)
{
    $id = getIdFromUrl($pokemon->url);
    // if ($id < 860)
        // continue;
    $pokemonData = getDataFromFile('/pokemon/' .$id);
    $pokemonFormData = getDataFromFile('/pokemon-form/' . getIdFromUrl($pokemonData->forms[0]->url));
    $pokemonSpeciesData = getDataFromFile('/pokemon-species/' . getIdFromUrl($pokemonData->species->url));
    // echo print_r($pokemonSpeciesData) . $id;
    $pokemonEvolutionData = getDataFromFile('/evolution-chain/' . getIdFromUrl($pokemonSpeciesData->evolution_chain->url));
    $pokemonEncounterData = getDataFromFile('/pokemon/'. $id . '/encounters');
    //echo $pokemonData->id;
    //echo '<br>';


    for ($j = 0; $j < count($pokemonData->abilities); $j++)
    {
        if ($pokemonData->abilities[$j]->slot == 3 && exists($pokemonData->abilities[0], ['ability', 'url']) == $pokemonData->abilities[$j]->ability->url) { continue; }
        $APvalues = $APvalues . '(' . getIdFromUrl($pokemonData->abilities[$j]->ability->url) . ','. $pokemonData->id . ',' . BooleanValue($pokemonData->abilities[$j]->is_hidden) . '),,'; //ability_pokemon (table)
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
            $MPvalue = '(';
            $MPvalue = $MPvalue . getIdFromUrl($pokemonData->moves[$j]->move->url) . ',';
            $MPvalue = $MPvalue . $pokemonData->id . ',';
            $MPvalue = $MPvalue . (getTextFromData(getDataFromFile('/move-learn-method/' . $learnMethodId)->names, 'name') == '"NULL///NULL"' ? '"' . getStringReplace(getDataFromFile('/move-learn-method/' . $learnMethodId)->name, false) . '///NULL"' : getTextFromData(getDataFromFile('/move-learn-method/' . $learnMethodId)->names, 'name')) . ',';
            $MPvalue = $MPvalue . IntValue($groups[$k]->level_learned_at) . ',';
            $MPvalue = $MPvalue . getIdFromUrl(getDataFromFile('/version-group/' . $versionGroupId)->generation->url) . ')';
            $MPvalues = $MPvalues . $MPvalue . ',,';
        }
    }

    for ($j = 0; $j < count($pokemonEncounterData); $j++)
    {
        $locationData = getDataFromfile('/location-area/' . getIdFromUrl($pokemonEncounterData[$j]->location_area->url)); 
        for ($k = 0; $k < count($pokemonEncounterData[$j]->version_details); $k++)
        {
            $versionData = getDataFromFile('/version-group/' . getIdFromUrl(getDataFromfile('/version/' . getIdFromUrl($pokemonEncounterData[$j]->version_details[$k]->version->url))->version_group->url));
            $LPvalues = $LPvalues . '(' . getIdFromUrl($locationData->location->url) . ','. $pokemonData->id . ',' . getIdFromUrl($versionData->generation->url) . '),,'; //location_pokemon (table)
        }
    }
        
    if ($pokemonEvolutionData != null && $pokemonData->id != 489 && $pokemonData->id != 490)
    {
        $EPvalues = $EPvalues . '(' . $id . ', ' .  getIdFromUrl($pokemonSpeciesData->evolution_chain->url) . '),,';
    }
    if ($pokemonData->id < 10000)
    {
        for ($j = 1; $j < count($pokemonSpeciesData->varieties); $j++)
        {
            $FPvalues = $FPvalues . '(' . getIdFromUrl($pokemonSpeciesData->varieties[0]->pokemon->url) . ',' . getIdFromUrl($pokemonSpeciesData->varieties[$j]->pokemon->url) . '),,';
        }
    }
        
    $value = '(' . $pokemonData->id . ','; //id
    if ($pokemonFormData == null)
    echo 'pb : ' . $id . ' ';
    if ($pokemonFormData->names != null)
    {
        $value = $value . (getTextFromData($pokemonFormData->names, 'name') == '"NULL///NULL"' ? '"' . getStringReplace($pokemonFormData->name, false) . '///NULL"' : getTextFromData($pokemonFormData->names, 'name')) . ','; //name
    }
    else
    {
        $value = $value . (getTextFromData($pokemonSpeciesData->names, 'name') == '"NULL///NULL"' ? '"' . getStringReplace($pokemonSpeciesData->name, false) . '///NULL"' : getTextFromData($pokemonSpeciesData->names, 'name')) . ','; //name
    }
    $value = $value . getTextFromData($pokemonSpeciesData->flavor_text_entries, 'flavor_text') . ','; //description
    $value = $value . getTextFromData($pokemonSpeciesData->genera, 'genus') . ','; //species
    if ($pokemonSpeciesData->is_legendary) //category
    {
        $value = $value . '1,';
    }
    else if ($pokemonSpeciesData->is_mythical)
    {
        $value = $value . '2,';
    }
    else
    {
        $value = $value . '0,';
    }
    $value = $value . getIdFromUrl($pokemonSpeciesData->generation->url) . ','; //generation
    $value = $value . getStringReplace($pokemonData->sprites->front_default) . ','; //priteM
    $value = $value . getStringReplace($pokemonData->sprites->front_female) . ','; //spriteF
    $value = $value . getIdFromUrl($pokemonData->types[0]->type->url) . ','; //type
    if (count($pokemonData->types) == 2)
    {
        $value = $value . getIdFromUrl($pokemonData->types[1]->type->url) . ',';
    }
    else
    {
        $value = $value . 'NULL,';
    }
    $value = $value . IntValue($pokemonData->stats[0]->base_stat) . ','; //hp
    $value = $value . IntValue($pokemonData->stats[1]->base_stat) . ','; //attack
    $value = $value . IntValue($pokemonData->stats[2]->base_stat) . ','; //defense
    $value = $value . IntValue($pokemonData->stats[3]->base_stat) . ','; //attackSpe
    $value = $value . IntValue($pokemonData->stats[4]->base_stat) . ','; //defenseSpe
    $value = $value . IntValue($pokemonData->stats[5]->base_stat) . ','; //speed
    $found = false;
    for ($j = 0; $j < count($pokemonSpeciesData->varieties); $j++)
    {
        if (getDataFromfile('/pokemon-form/' . getIdFromUrl($pokemonSpeciesData->varieties[$j]->pokemon->url))->is_mega == true)
        {
            $value = $value . 'TRUE,'; //mega
            $found = true;
            break;
        }
    }
    if ($found != true)
    {
        $value = $value . 'FALSE,'; //mega
    }
    $value = $value . $pokemonData->height. ','; //height
    $value = $value . $pokemonData->weight . ','; //weight
    $value = $value . $pokemonSpeciesData->capture_rate . ','; //catch_rate
    $value = $value . count($pokemonData->forms) . ','; //number of forms
    
    if ($pokemonData->id < count($typeEfficiencyData))
    {
        $typeData = ['Normal' => 0, 'Combat' => 0, 'Vol' => 0, 'Poison' => 0, 'Sol' => 0, 'Roche' => 0, 'Insecte' => 0, 'Spectre' => 0, 'Acier' => 0, 'Feu' => 0, 'Eau' => 0, 'Plante' => 0, 'Électrik' => 0, 'Psy' => 0, 'Glace' => 0, 'Dragon' => 0, 'Ténèbres' => 0, 'Fée' => 0] ;
        $resistances = $typeEfficiencyData[$pokemonData->id]->resistances;
        for ($j = 0; $j < count($resistances); $j++)
        {
            $typeData[$resistances[$j]->name] = $resistances[$j]->multiplier;
        }
        $value = $value . '"' . $typeData['Normal'];
        foreach($typeData as $key)
        {
            $value = $value . '/' . $key;
        }
        $value = $value . '"';
    }
    else
    {
        $value = $value . 'NULL';
    }
    $values = $values . $value . '),,';
    
}
saveToDb($sqlInsertPokemon, 'pokemon', $values, false);
saveToDb($sqlInsertAbilityPokemon, 'ability_pokemon', $APvalues);
saveToDb($sqlInsertMovePokemon, 'move_pokemon', $MPvalues);
saveToDb($sqlInsertLocationPokemon, 'location_pokemon', $LPvalues);
saveToDb($sqlInsertEvolutionPokemon, 'evolution_pokemon', $EPvalues);
saveToDb($sqlInsertFormPokemon, 'form_pokemon', $FPvalues);

$sqlAddBonusData = 'UPDATE pokemon SET category=3 WHERE id IN (793, 794, 795, 796, 797, 798, 799, 803, 804, 805, 806);';
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE pokemon SET category=4 WHERE id IN (984, 985, 986, 987, 988, 989, 990, 991, 992, 993, 994, 995, 1005, 1006, 1009, 1010, 1020, 1021, 1022, 1023);';
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE pokemon SET name=\'Silvally///Silvallié\' WHERE id=773;';
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE pokemon SET name=\'Phony Polteageist///Polthégeist Authentique\' WHERE id=855;';
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE pokemon SET typeEfficiency=\'1/1/2/1/1/1/1/1/0/1/1/1/1/1/1/1/1/1/1\' WHERE id=432;';
$sqlAddBonusData = $sqlAddBonusData . 'UPDATE pokemon SET typeEfficiency=\'0.5/0.5/2/0.25/0/4/0.5/0.5/1/0.25/2/1/0.5/0.5/0.5/0.5/0.5/1/0.5\' WHERE id=855;';
$sqlAddBonusData = $sqlAddBonusData . 'INSERT INTO pokemon (id, name, description, species, category, generation, spriteM, spriteF, type1, type2, hp, attack, defense, atackspe, defensespe, speed ,mega ,height, weight, catch_rate, form, typeEfficiency) 
VALUES (60000, \'Masterpiece Form Sinistcha///Théffroyable Forme Exceptionnelle\',\'It prefers cool, dark places, such as the back of a shelf or the space beneath a home\\\'s floorboards. It wanders in search of prey after sunset.///NULL\',\'Matcha Pokémon///Matcha\',0,9,\'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1013.png\',NULL,12,8,71,60,106,121,80,70,FALSE,2,22,60,2,\'0/0/0/2/1/0.5/1/1/2/1/2/0.5/0.5/0.5/1/2/1/2/1\');';
saveToDb($sqlAddBonusData, '', '', false, true);
//$statement = $db->prepare($sqlAddBonusData);
//$statement->execute();