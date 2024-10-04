<?php
include_once("extractApi.php");

$sqlInsertMove = "INSERT INTO move (id, name, description, smallDescription, accuracy, type, pp, pc, effectType, comboMin, comboMax, priority, criticity) VALUES ";
$values = "";
echo count(getDataFromFile("/move")->results);
//echo "<br>";

foreach (getDataFromFile("/move")->results as $move)
{
    $moveData = getDataFromFile("/move/" . getIdFromUrl($move->url));
    //echo $moveData->id;
    //echo "<br>";
    if ($moveData->id > 9999) {break;}
    $value = "(" . $moveData->id . ','; //id
    $value = $value . getTextFromData($moveData->names, "name") . ","; //name
    $value = $value . getTextFromData($moveData->effect_entries, "effect") . ","; //description
    $value = $value . getTextFromData($moveData->effect_entries, "short_effect") . ","; //smallDescription
    $value = $value . IntValue($moveData->accuracy) . "," ; //accurary
    $value = $value . getIdFromUrl($moveData->type->url) . ","; //type
    $value = $value . IntValue($moveData->power) . ","; //pc
    $value = $value . IntValue($moveData->pp) . ","; //pp
    if ($moveData->damage_class->name == "physicial") //effetctType
    {
        $value = $value . "1,";
    }
    else if ($moveData->damage_class->name == "special")
    {
        $value = $value . "2,";
    }
    else
    {
        $value = $value . "3,";
    }
    $value = $value . IntValue($moveData->meta?->min_hits) . ","; //comboMin
    $value = $value . IntValue($moveData->meta?->max_hits) . ","; //comboMax
    $value = $value . IntValue($moveData->priority) . ","; //priority
    $value = $value . IntValue($moveData->meta?->crit_rate); //criticity
    $value = $value . ')';
    $values = $values . $value . ",";
    
}
saveToDb($sqlInsertMove, "move", $values)
?>