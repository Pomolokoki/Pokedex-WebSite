<?php
$MYSQL_HOST = 'localhost';
$MYSQL_PORT = 3306;
$MYSQL_NAME = 'pokedex';
$MYSQL_USER = 'root';
// $MYSQL_PASSWORD = 'root';

try {
$db = new PDO(
    sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8',
    $MYSQL_HOST, $MYSQL_NAME, $MYSQL_PORT),
    $MYSQL_USER,
    // $MYSQL_PASSWORD
);


$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $exception) {
die('Erreur : '.$exception->getMessage());
}

?>