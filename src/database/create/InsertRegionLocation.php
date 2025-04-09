<?php
include_once 'extractApi.php';

//echo '<br>';
$sqlInsertRegion = 'INSERT INTO region (id, name) VALUES ';
$sqlInsertLocation = 'INSERT INTO location (id, name, regionId) VALUES ';
$valuesR = '';
$valuesL = '';

foreach(getDataFromFile('/region')->results as $region)
{
    $regionData = getDataFromFile('/region/' . getIdFromUrl($region->url));
    $value = '(' . $regionData->id . ','; //id
    $value = $value . (getTextFromData($regionData->names, 'name') == '"NULL///NULL"' ? '"' . getStringReplace($regionData->name, false) . '///NULL"' : getTextFromData($regionData->names, 'name')); //name
    $valuesR = $valuesR . $value . '),,';
}

saveToDb($sqlInsertRegion, 'region', $valuesR);


foreach(getDataFromFile('/location')->results as $location)
{
    $locationData = getDataFromFile('/location/' . getIdFromUrl($location->url));
    $value = '(' . $locationData->id . ','; //id
    //echo getTextFromData($locationData->names, 'name');
    //echo getTextFromData($locationData->names, 'name') == '"NULL///NULL"' ? 'oui' : 'non';
    $value = $value . (getTextFromData($locationData->names, 'name') == '"NULL///NULL"' ? '"' . getStringReplace($locationData->name, false) . '///NULL"' : getTextFromData($locationData->names, 'name')) . ','; //name
    //str_replace('NULL///NULL', $locationData->name, $value);
    $value = $value . getIdFromUrl(exists($locationData, ['region', 'url'])); //region
    $valuesL = $valuesL . $value . '),,';
}

saveToDb($sqlInsertLocation, 'location', $valuesL);