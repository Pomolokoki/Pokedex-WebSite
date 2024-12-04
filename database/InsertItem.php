<?php
include_once("extractApi.php");

$sqlInsertItem = "INSERT INTO item (id, name, description, smallDescription, sprite, category, pocket, effect, throwEffect, throwValue, machineName, machineId) VALUES ";
$values = "";
//echo getDataFromApi($curl_handle, $baseUrl . "/item")->count;
//echo "<br>";

foreach(getDataFromFile("/item")->results as $item)
{
    
    $itemData = getDataFromFile("/item/" . getIdFromUrl($item->url));
    $value = "(" . $itemData->id . ','; //id
    //echo $itemData->id;
    //echo "<br>";
    $value = $value . getTextFromData($itemData->names, "name") . ","; //name
    $value = $value . getTextFromData($itemData->effect_entries, "effect") . ","; //description
    $value = $value . getTextFromData($itemData->effect_entries, "short_effect") . ","; //smallDescription
    $value = $value . getStringReplace($itemData->sprites->default). ","; //sprite
    $value = $value . getStringReplace($itemData->category->name) . ","; //category
    $value = $value . getStringReplace(getDataFromFile("/item-category/" . getIdFromUrl($itemData->category->url))->pocket->name) . ","; //pocket
    $value = $value . getTextFromData($itemData->flavor_text_entries, "text") . ","; //effect
    if ($itemData->fling_effect == null)
    {
        $value = $value . "NULL,";
    }
    else
    {
        $value = $value . getTextFromData(getDataFromFile("/item-fling-effect/" . getIdFromUrl($itemData->fling_effect->url))->effect_entries, "effect") . ","; //throwEffect
    }
    $value = $value . IntValue($itemData->fling_power) . ","; //throwValue

    $machineFound = false ;
    for ($j = 0; $j < count($itemData->machines); $j++)
    {
        if ($itemData->machines[$j]->version_group->name != "scarlet-violet")
        { continue; }
        
        $machine = getDataFromFile("/machine/" . getIdFromUrl($itemData->machines[$j]->machine->url));
        $value = $value . getStringReplace($machine->item->name . "/" . str_replace("hm", "cs", str_replace("tm", "ct", $machine->item->name))) . ',';
        $value = $value . getIdFromUrl($machine->move->url);
        $machineFound = true;
    }
    if(count($itemData->machines) == 0 || !$machineFound)
    {
        $value = $value . "NULL,NULL";
    }

    $value = $value . ')';
    $values = $values . $value . ",,";
    // if ($i == 20)
    // {
    //     break;
    // }
}
saveToDb($sqlInsertItem, "item", $values);
saveToDb("INSERT INTO item (id, name) VALUES (60000, 'Metal alloy/Métal Composite')", "", "", false, true);
//$statement = $db->prepare("INSERT INTO item (id, name) VALUES (10000, 'Metal alloy/Métal Composite')");
//$statement->execute();
?>