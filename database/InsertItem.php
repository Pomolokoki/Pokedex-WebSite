<?php
include_once 'extractApi.php';

$sqlInsertItem = 'INSERT INTO item (id, name, description, smallDescription, sprite, category, pocket, effect, throwEffect, throwValue, machineName, machineId) VALUES ';
$values = '';
//echo getDataFromApi($curl_handle, $baseUrl . '/item')->count;
//echo '<br>';

foreach(getDataFromFile('/item')->results as $item)
{
    
    $itemData = getDataFromFile('/item/' . getIdFromUrl($item->url));
    $value = '(' . $itemData->id . ','; //id
    //echo $itemData->id;
    //echo '<br>';
    $value = $value . (getTextFromData($itemData->names, 'name') == '"NULL///NULL"' ? '"' . getStringReplace($itemData->name, false) . '///NULL"' : getTextFromData($itemData->names, 'name')) . ','; //name
    $value = $value . getTextFromData($itemData->effect_entries, 'effect') . ','; //description
    $value = $value . getTextFromData($itemData->effect_entries, 'short_effect') . ','; //smallDescription
    $value = $value . getStringReplace($itemData->sprites->default). ','; //sprite
    $value = $value . getStringReplace($itemData->category->name) . ','; //category
    $value = $value . getStringReplace(getDataFromFile('/item-category/' . getIdFromUrl($itemData->category->url))->pocket->name) . ','; //pocket
    $value = $value . getTextFromData($itemData->flavor_text_entries, 'text') . ','; //effect
    if ($itemData->fling_effect == null)
    {
        $value = $value . 'NULL,';
    }
    else
    {
        $value = $value . getTextFromData(getDataFromFile('/item-fling-effect/' . getIdFromUrl($itemData->fling_effect->url))->effect_entries, 'effect') . ','; //throwEffect
    }
    $value = $value . IntValue($itemData->fling_power) . ','; //throwValue

    $machineFound = false ;
    for ($j = 0; $j < count($itemData->machines); $j++)
    {
        if ($itemData->machines[$j]->version_group->name != 'scarlet-violet')
        { continue; }
        
        $machine = getDataFromFile('/machine/' . getIdFromUrl($itemData->machines[$j]->machine->url));
        $value = $value . getStringReplace($machine->item->name . '/' . str_replace('hm', 'cs', str_replace('tm', 'ct', $machine->item->name))) . ',';
        $value = $value . getIdFromUrl($machine->move->url);
        $machineFound = true;
    }
    if(count($itemData->machines) == 0 || !$machineFound)
    {
        $value = $value . 'NULL,NULL';
    }

    $value = $value . ')';
    $values = $values . $value . ',,';
    // if ($i == 20)
    // {
    //     break;
    // }
}
saveToDb($sqlInsertItem, 'item', $values);
saveToDb('INSERT INTO item (id, name, description, smallDescription, sprite, category, pocket, effect, throwEffect, throwValue, machineName, machineId) VALUES (60000, \'Metal alloy///Métal Composite\', \'"NULL///NULL"\',\'"NULL///NULL"\', \'https://www.pokepedia.fr/images/d/d5/Miniature_M%C3%A9tal_Composite_EV.png\',\'evolution\',\'misc\',\'"NULL///NULL"\',NULL,NULL,NULL,NULL)', '', '', false, true);
saveToDb('UPDATE item SET name=\'Black-Augurite///Obsidienne\', sprite=\'https://www.pokepedia.fr/images/c/c4/Miniature_Obsidienne_LPA.png\' WHERE id=10001', null, null, false, true);
saveToDb('UPDATE item SET name=\'Peat-Block\///Bloc de Tourbe\', sprite=\'https://www.pokepedia.fr/images/0/09/Miniature_Bloc_de_Tourbe_LPA.png\' WHERE id=10002', null, null, false, true);
saveToDb('UPDATE item SET sprite=\'https://archives.bulbagarden.net/media/upload/d/dc/Bag_Auspicious_Armor_SV_Sprite.png\' WHERE id=2045', null, null, false, true);
saveToDb('UPDATE item SET sprite=\'https://www.pokepedia.fr/images/4/49/Miniature_Pomme_Acidul%C3%A9e_EV.png\' WHERE id=1175', null, null, false, true);
saveToDb('UPDATE item SET sprite=\'https://www.pokepedia.fr/images/0/0d/Miniature_Pomme_Sucr%C3%A9e_EV.png\' WHERE id=1174', null, null, false, true);
saveToDb('UPDATE item SET sprite=\'https://www.pokepedia.fr/images/0/0b/Miniature_Pomme_Nectar_EV.png\' WHERE id=2109', null, null, false, true);
saveToDb('UPDATE item SET sprite=\'https://www.pokepedia.fr/images/7/70/Miniature_Bol_M%C3%A9diocre_EV.png\' WHERE id=2110', null, null, false, true);
saveToDb('UPDATE item SET sprite=\'https://www.pokepedia.fr/images/0/0f/Miniature_Bol_Exceptionnel_EV.png\' WHERE id=2111', null, null, false, true);
//$statement = $db->prepare('INSERT INTO item (id, name) VALUES (10000, 'Metal alloy///Métal Composite')');
//$statement->execute();