<?php
include_once 'extractApi.php';

$sqlInsertAbility = 'INSERT INTO ability (id, name, description, smallDescription, effect) VALUES ';
$values = '';
echo getDataFromfile('/ability')->count;
echo '<br>';

foreach(getDataFromFile('/ability')->results as $ability)
{
    //echo $i;
    //echo '<br>';
    $abilityData = getDataFromFile('/ability/' . getIdFromUrl($ability->url));
    if ($abilityData->is_main_series == false) { break; }
    $value = '(' . $abilityData->id . ','; //id
    $value = $value . (getTextFromData($abilityData->names, 'name') == '"NULL///NULL"' ? '"' . getStringReplace($abilityData->name, false) . '///NULL"' : getTextFromData($abilityData->names, 'name')) . ','; //name
    $value = $value . getTextFromData($abilityData->effect_entries, 'effect') . ','; //description
    $value = $value . getTextFromData($abilityData->effect_entries, 'short_effect') . ','; //smallDescription
    $value = $value . getTextFromData($abilityData->flavor_text_entries, 'flavor_text'); //effect
    $value = $value . ')';
    $values = $values . $value . ',,';
    // if ($i == 20)
    // {
    //     break;
    // }
}
saveToDb($sqlInsertAbility, 'ability', $values);