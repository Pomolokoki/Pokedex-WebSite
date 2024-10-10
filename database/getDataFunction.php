<?php
include_once("connectSQL.php");

function getStringReplace($string, $addQuote = true)
{
    if ($string == null)
    {
        return "NULL";
    }
    else if ($addQuote)
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
    if ($data == null || count($data) == 0)
    {
        return '"NULL/NULL"';
    }
    $return = '"';
    $fr = -1;
    for ($j = 0; $j < count($data); $j++) //name
    {
        if ($data[$j]->language->name == "en")
        {
            $return = $return . getStringReplace($data[$j]->$value, false);
        }
        if ($data[$j]->language->name == "fr")
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
    if ($url == null)
    {
        return "NULL";
    }
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
    //$values = rtrim($values, ",");
    global $db;
    if ($delete)
    {
        $statement = $db->prepare("DELETE FROM " . $table . " WHERE 1 = 1;");
        $statement->execute();
        if ($deleteOnly) { return; }
    }
    $data = preg_split("(,,)", $values);
    echo $values;
    echo "<br>";
    echo "<br>";
    echo count($data);
    echo "<br>";
    echo "<br>";
    $dataToSave = "";
    for ($i = 0; $i < count($data); $i++)
    {
        if (($i != 0 && $i % 100 == 0) || $i == count($data) - 1)
        {
            $dataToSave = $dataToSave . $data[$i] . ",";
            $dataToSave = rtrim($dataToSave, ",,");
            echo $insert . $dataToSave;
            $statement = $db->prepare($insert . $dataToSave);
            $statement->execute();
            $dataToSave = "";
        }
        else {
            $dataToSave = $dataToSave . $data[$i] . ",";
        }
    }
    //$statement = $db->prepare($insert . $values);
    //$statement->execute();
    $statement = $db->prepare("SELECT * FROM " . $table);
    $statement->execute();
    $returnValue = $statement->fetchAll();
    //echo json_encode($returnValue);
}
function exists($base, $path)
{
    if (count($path) == 0)
    {
        return $base;
    }
    else if ($base == null)
    {
        return null;
    }
    $str = $path[0];
    if ($base->$str == null)
    {
        return null;
    }
    else
    {
        return exists($base->$str, array_slice($path, 1, count($path)));
    }
}
?>