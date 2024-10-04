<?php
include_once("extractdata.php");

function getStringReplace($string, $addQuote = true)
{
    if ($addQuote)
    {
        return '"' . str_replace('"','\\"',$string) . '"';
    }
    else 
    {
        return str_replace('"','\\"',$string);
    }
}

function getTextFromData($data, $value)
{
    if (count($data) == 0)
    {
        return '"NULL/NULL"';
    }
    $return = '"';
    $fr = -1;
    for ($j = 0; $j < count($data); $j++) //name
    {
        if ($data[$j]?->language?->name == "en")
        {
            $return = $return . getStringReplace($data[$j]->$value, false);
        }
        if ($data[$j]?->language?->name == "fr")
        {
            $fr = $j;
        }
    }
    if ($fr == -1)
    {
        $return = $return . '/NULL"';
    }
    else
    {
        $return = $return . '/' . getStringReplace($data[$fr]->$value, false) . '"';
    }
    return $return;
}

function getIdFromUrl($url)
{
    $split = explode('/', $url);
    return $split[count($split) - 2];
}


function IntValue($value)
{
    return $value == null ? "NULL" : $value;
}
function BooleanValue($value)
{
    return $value == true ? "TRUE" : "FALSE";
}

function saveToDb($insert, $table, $values, $delete = true, $deleteOnly = false)
{
    $values = rtrim($values, ",");
    global $db;
    if ($delete)
    {
        $statement = $db->prepare("DELETE FROM " . $table . " WHERE 1 = 1;");
        $statement->execute();
        if ($deleteOnly) { return; }
    }
    
    echo $insert . $values;
    //echo "br";
    $statement = $db->prepare($insert . $values);
    $statement->execute();
    $returnValue = $statement->fetchAll();
    echo json_encode($returnValue);
}
?>