<?php
include_once 'connectSQL.php';
include_once 'sqlQuery.php';

function getStringReplace($string, $addQuote = true)
{
    if ($string == null) {
        return 'NULL';
    } else if ($addQuote) {
        // $string = str_replace('/', '\/', $string);
        // $string = str_replace('\\', '\\\\', $string);
        return '"' . str_replace('"', '\"', $string) . '"';
    } else {
        // $string = str_replace('/', '\/', $string);
        // $string = str_replace('\\', '\\\\', $string);
        return str_replace('"', '\"', $string);
    }
}

function getTextFromData($data, $value)
{
    if ($data == null || count($data) == 0) {
        return '"NULL///NULL"';
    }
    $return = '"';
    $fr = -1;
    $en = -1;
    for ($j = 0; $j < count($data); $j++) //name
    {
        if ($data[$j]->language->name == 'en') {
            $en = $j;
        }
        if ($data[$j]->language->name == 'fr') {
            $fr = $j;
        }
    }
    if ($en == -1) {
        $return = $return . 'NULL';
    } else {
        $return = $return . getStringReplace($data[$en]->$value, false);
    }
    if ($fr == -1) {
        $return = $return . '///NULL"';
    } else {
        $return = $return . '///' . getStringReplace($data[$fr]->$value, false) . '"';
    }
    return $return;
}

function getIdFromUrl($url)
{
    if ($url == null) {
        return 'NULL';
    }
    $split = explode('/', $url);
    return $split[count($split) - 2];
}


function IntValue($value)
{
    return $value == null ? 'NULL' : $value;
}
function BooleanValue($value)
{
    return $value == true ? 'TRUE' : 'FALSE';
}

function saveToDb($insert, $table, $values, $delete = true, $deleteOnly = false)
{
    $values = rtrim($values, ',,');
    global $db;
    $file = 'pokedexFromPhp.sql';
    $current = file_get_contents($file);
    if ($delete) {
        //$current .= 'DELETE FROM ' . $table . ' WHERE 1 = 1;\n';
        $statement = $db->prepare('DELETE FROM ' . $table . ' WHERE 1 = 1;');
        $statement->execute();
        if ($deleteOnly) {
            //file_put_contents($file, $current);
            return;
        }
    }
    $data = preg_split('(,,)', $values);
    // echo $values;
    // echo '<br>';
    // echo '<br>';
    echo count($data);
    // echo '<br>';
    // echo '<br>';
    $dataToSave = '';
    for ($i = 0; $i < count($data); $i++) {
        if (($i != 0 && $i % 100 == 0) || $i == count($data) - 1) {
            $dataToSave = $dataToSave . $data[$i];
            $dataToSave = rtrim($dataToSave, ',,');
            echo $insert . $dataToSave;
            $current .= $insert . "\n" . $dataToSave . ";\n\n";
            $statement = $db->prepare($insert . $dataToSave);
            $statement->execute();
            $dataToSave = '';
        } else {
            $dataToSave = $dataToSave . $data[$i] . "\n,";
        }
    }

    file_put_contents($file, $current);

    //$statement = $db->prepare($insert . $values);
    //$statement->execute();
    if (!$delete && $deleteOnly)
        return;
    $statement = $db->prepare('SELECT * FROM ' . $table);
    $statement->execute();
    $returnValue = $statement->fetchAll();
    //echo json_encode($returnValue);
}
function exists($base, $path)
{
    if (count($path) == 0) {
        return $base;
    } else if ($base == null) {
        return null;
    }
    $str = $path[0];
    if ($base->$str == null) {
        return null;
    } else {
        return exists($base->$str, array_slice($path, 1, count($path)));
    }
}