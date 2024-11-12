<?php

// $sqlCreateRegion =
// "CREATE TABLE region(
// id TINYINT UNSIGNED,
// name VARCHAR(75)
// );";

// $sqlCreateLocation =
// "CREATE TABLE location(
// id SMALLINT UNSIGNEd,
// name VARCHAR(100),
// regionId TINYINT USNIGNED,
// CONSTRAINT location_regionId_FK FOREIGN KEY (regionId) REFERENCES region(id)
// );";
//echo getDataFromApi($curl_handle, $baseUrl . "/item")->count;
//echo "<br>";
$sqlInsertRegion = "INSERT INTO region (id, name) VALUES ";
$sqlInsertLocation = "INSERT INTO location (id, name, region) VALUES ";
$valuesR = "";
$valuesL = "";
foreach(getDataFromFile("/region")->results as $region)
{
    $regionData = getDataFromFile("/region/" . getIdFromUrl($region->url));
    if ($regionData->id >= 19) {break;}
    $value = "(" . $regionData->id . ','; //id
    $value = $value . getTextFromData($regionData->names, "name") . ","; //name
    $valuesR = $valuesR . $value . ",";
}
saveToDb($sqlInsertRegion, "region", $valuesR);


foreach(getDataFromFile("/location")->results as $location)
{
    $locationData = getDataFromFile("/location/" . getIdFromUrl($location->url));
    if ($locationData->id >= 19) {break;}
    $value = "(" . $regionData->id . ','; //id
    $value = $value . getTextFromData($locationData->names, "name") . ","; //name
    $value = $value . getIdFromUrl($locationData?->region?->url) . ","; //region
    $valuesL = $valuesL . $value . ",";
}
saveToDb($sqlInsertLocation, "location", $valuesL)
?>