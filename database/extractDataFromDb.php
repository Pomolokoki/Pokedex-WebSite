
<?php
include_once("connectSQL.php");
$language = "fr";
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
    if ($statement->rowCount() == 0)
        return "No results found.";
    return $statement->fetchAll();
}
 
function getTextLang($str, $language = "fr")
{
    $split = explode('///', $str);
    if ($language == "fr")
    {
        if ($split[1] == "NULL")
          return $split[0];
        return $split[1];
    }
    else
    {
        return $split[0];
    }
}

?>