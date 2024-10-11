<?php
include_once("extractApi.php");
include_once("extractData.php");

$sqlInsertType = "INSERT INTO type (id, name, efficiency, sprite) VALUES ";
$values = "";
//echo getDataFromApi($curl_handle, $baseUrl . "/type")->count;
//echo "<br>";

foreach(getDataFromFile("/type")->results as $type)
{
    //echo $i;
    //echo "<br>";
    $typeData = getDataFromFile("/type/" . getIdFromUrl($type->url));
    //if ($typeData->id >= 19) {break;}
    $value = "(" . $typeData->id . ','; //id
    $value = $value . getTextFromData($typeData->names, "name") . ","; //name
    $types = array_fill(0, 19, 1); //efficiency
    for ($k = 0; $k < count($typeData->damage_relations->double_damage_to); $k++)
    {
        $split = explode( '/', $typeData->damage_relations->double_damage_to[$k]->url);
        $types[$split[count($split) - 2]] = 2;
    }
    for ($k = 0; $k < count($typeData->damage_relations->half_damage_to); $k++)
    {
        $split = explode( '/', $typeData->damage_relations->half_damage_to[$k]->url);
        $types[$split[count($split) - 2]] = 0.5;
    }
    for ($k = 0; $k < count($typeData->damage_relations->no_damage_to); $k++)
    {
        $split = explode( '/', $typeData->damage_relations->no_damage_to[$k]->url);
        $types[$split[count($split) - 2]] = 0;
    }
    $value = $value . '"' . $types[0];
    for ($j = 1; $j < count($types); $j++)
    {
        $value = $value . "/" . $types[$j];
    }
    $value = $value . '","' . "./img/" . getTextLang(getTextFromData($typeData->names, "name"));
    $value = rtrim($value, '"');
    $values = $values . $value . '.png"),,';
    // if ($i == 20)
    // {
    //     break;
    // }
}
saveToDb($sqlInsertType, "type", $values)
?>