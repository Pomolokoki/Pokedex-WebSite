<?php
include_once("extractApi.php");
// $sqlCreateMovePokemonLink = 
// "CREATE TABLE move_pokemon(
// moveId SMALLINT UNSIGNED,
// pokemonId SMALLINT UNSIGNED,
// learnMethod TINYINT UNSIGNED,
// learnAtLevel TINYINT UNSIGNED,
// CONSTRAINT move_pokemon_moveId_FK FOREIGN KEY (moveId) REFERENCES move(id),
// CONSTRAINT move_pokemon_pokemonId_FK FOREIGN KEY (pokemonId) REFERENCES pokemon(id)
// );";
$sqlInsertAbilityPokemon = "INSERT INTO ability_pokemon (abilityId, pokemonId, isHidden) VALUES ";
$sqlInsertMovePokemon = "INSERT INTO move_pokemon (moveId, pokemonId, learnMethod, learnAtLevel) VALUES ";
$sqlInsertPokemon = "INSERT INTO pokemon (id, name, description, species, category, generation, spriteM, spriteF, type1, type2, hp, attack, defense, atackspe, defensespe, speed ,mega ,height, weight, catch_rate, form) VALUES ";
$APvalues = "";
$MPvalues = "";
$values = "";

echo count(getDataFromFile("/pokemon")->results);
//echo "<br>";
set_time_limit(120);
saveToDb($sqlInsertAbilityPokemon, "ability_pokemon", "", true, true);
saveToDb($sqlInsertMovePokemon, "move_pokemon", "", true, true);
saveToDb($sqlInsertMovePokemon, "pokemon", "", true, true);

foreach (getDataFromFile("/pokemon")->results as $move)
{
    $id = getIdFromUrl($move->url);
    $pokemonData = getDataFromFile("/pokemon/" .$id);
    $pokemonFormData = getDataFromFile("/pokemon-form/" . getIdFromUrl($pokemonData->forms[0]->url));
    $pokemonSpeciesData = getDataFromFile("/pokemon-species/" . getIdFromUrl($pokemonData->species->url));
    $pokemonEvolutionData = getDataFromFile("/evolutionChain/" . getIdFromUrl($pokemonSpeciesData->evolution_chain->url));
    //echo $pokemonData->id;
    //echo "<br>";


    for ($j = 0; $j < count($pokemonData->abilities); $j++)
    {
        $APvalues = $APvalues . "(" . getIdFromUrl($pokemonData->abilities[$j]->ability->url) . ",". $pokemonData->id . "," . BooleanValue($pokemonData->abilities[$j]->is_hidden) . "),"; //ability_pokemon (table)
    }


    
    for ($j = 0; $j < count($pokemonData->moves); $j++)
    {
        $groups = $pokemonData->moves[$j]->version_group_details;
        $group = $groups[count($groups) - 1];
        if ($group->version_group->name != "scarlet-violet")
        { break; }
            
            $learnMethodId = getIdFromUrl($group->move_learn_method->url);
            if ($learnMethodId == 9 || $learnMethodId == 8 || $learnMethodId == 7)
            {
                continue;
            }
            $MPvalue = "(";
            $MPvalue = $MPvalue . getIdFromUrl($pokemonData->moves[$j]->move->url) . ",";
            $MPvalue = $MPvalue . $pokemonData->id . ",";
            $MPvalue = $MPvalue . getTextFromData(getDataFromFile("/move-learn-method/" . $learnMethodId)->names, "name") . ",";
            $MPvalue = $MPvalue . IntValue($group->level_learned_at) . ")";
            $MPvalues = $MPvalues . $MPvalue . ",";
    }




    $value = "(" . $pokemonData->id . ','; //id
    $value = $value . getTextFromData($pokemonSpeciesData->names, "name") . ","; //name
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
    else {
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
    $value = $value . count($pokemonData->forms); //number of forms

    $value = $value . ')';
    $values = $value . "," . $values;
    if ($pokemonData->id % 300 == 0)
    {
        saveToDb($sqlInsertPokemon, "pokemon", $values, false);
        $values = "";
    }
    
}
saveToDb($sqlInsertPokemon, "pokemon", $values, false);
saveToDb($sqlInsertAbilityPokemon, "ability_pokemon", $APvalues);
saveToDb($sqlInsertMovePokemon, "move_pokemon", $MPvalues);
?>