
<?php
const MYSQL_HOST = 'localhost';
const MYSQL_PORT = 3306;
const MYSQL_NAME = 'pokedex';
const MYSQL_USER = 'root';
const MYSQL_PASSWORD = 'root';
try {
$db = new PDO(
sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8',
MYSQL_HOST, MYSQL_NAME, MYSQL_PORT),
MYSQL_USER,
//MYSQL_PASSWORD
);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $exception) {
die('Erreur : '.$exception->getMessage());
}

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

function getTextFr($str)
{
    $split = explode('/', $str);
    return $split[count($split) - 1];
}
?>

