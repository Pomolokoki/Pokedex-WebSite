
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
    $split = explode('/', $str);
    if ($language == "fr")
    {
        if ($split[0] == "NULL")
          return $split[0];
        return $split[1];
    }
    else
    {
        return $split[0];
    }
}

?>