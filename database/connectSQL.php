<?php
include_once 'configSQL.php';
$MYSQL_HOST = 'localhost';
$MYSQL_PORT = 3306;
$MYSQL_NAME = 'pokedex';
$MYSQL_USER = 'root';

try {
    $db = new PDO(
        sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8',
        $MYSQL_HOST, $MYSQL_NAME, $MYSQL_PORT),
        $MYSQL_USER,
        getPassword()
    );
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //include_once 'loadDataIntoWebsite.php';

} catch(Exception $exception) {
    if (str_contains($exception->getMessage(), 'Unknown database'))
    {
        include_once 'createSQL.php';
    }
    else
        die('Erreur : '. $exception->getMessage());
}