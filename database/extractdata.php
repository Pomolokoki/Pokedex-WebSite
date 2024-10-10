
<?php
include_once("connectSQL.php");
function getDataFromDB($table, $columns, $condition, $fullRequest = false)
{
    if ($fullRequest)
    {
        $sqlQuery = $table;
    }
    else if ($condition == null)
    {
        $sqlQuery = "SELECT " . $columns . " FROM " . $table;
    }
    else
    {
        $sqlQuery = "SELECT " . $columns . " FROM " . $table . " " . $condition;
    }
    global $db;
    $statement = $db->prepare($sqlQuery);
    $statement->execute();
    return $statement->fetchAll();
}
 
function getTextLang($str, $language = "fr")
{

    if ($language == "fr")
    {
        return explode('/', $str)[1];
    }
    else
    {
        return explode('/', $str)[0];
    }
}
?>